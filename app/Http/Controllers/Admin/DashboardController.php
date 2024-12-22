<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStockStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Patient;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductOut;
use App\Models\ProductStock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $patients = Patient::count();
        $totalProducts = ProductStock::where('status', ProductStockStatusEnum::AVAILABLE)->sum('stock');
        
        $costs = ProductIn::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get()
            ->sum(function ($productIn) {
                return $productIn->price * $productIn->quantity;
            });

        $revenues = Transaction::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('total_amount');

            $products = ProductStock::whereIn('status', [ProductStockStatusEnum::EXPIRED, ProductStockStatusEnum::NEAR_EXPIRED])
            ->orderBy('updated_at', 'DESC') // Sort by the 'updated_at' column in descending order
            ->limit(10)
            ->get();

        $expireds = ProductStock::whereIn('status', [ProductStockStatusEnum::EXPIRED, ProductStockStatusEnum::NEAR_EXPIRED])
        ->count();

        $datesCount = 0;
        $dates = [];
        $productInCount = [];
        $productOutCount = [];

        do {
            $date = now()->subDays($datesCount);
            $dates[] = $date->format('F j, Y');

            $productInCount[] = Transaction::whereDate('date', $date)->sum('total_amount');
            $productOutCount[] = ProductIn::whereDate('date', $date)
                ->selectRaw('SUM(price * quantity) as total')
                ->value('total') ?? 0; // Default to 0 if null

            $datesCount++;
        } while($datesCount < 7);

        return view('admin.pages.dashboard.index',
            compact('patients','totalProducts', 
                'products', 'dates',
                'productOutCount', 'productInCount', 'expireds', 'costs', 'revenues'));
    }
}
