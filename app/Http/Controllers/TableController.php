<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class TableController extends Controller
{

    public function index()
    {
        $tables = Table::paginate(10);

        return view('admin.pages.tables.index', compact('tables'));
    }

    public function create() 
    {
        return view('admin.pages.tables.create');
    }

    public function generateQRCode($refId, $redirectUrl, $tableNumber)
    {
        $writer = new PngWriter();
        $logoPath = public_path('assets/images/logo/umaisushi.png');
        $qrCode = QrCode::create($redirectUrl)
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        ->setSize(300);
    
        $logo = Logo::create($logoPath )
        ->setResizeToWidth(75)
        ->setPunchoutBackground(true)
        ;
        $label = Label::create('Table Number: '.$tableNumber)
        ->setTextColor(new Color(0, 0, 0));
    
        $filename = 'qrcode_' . $refId . '.png';
        $filePath = 'storage/qr_codes/' . $filename;



        $result = $writer->write($qrCode, $logo,  $label);
        $result->saveToFile($filePath);
        return $filePath;
    }

    public function addTable(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number'
        ]);

        $refId = (string) Str::uuid();
        $redirectUrl = route('customer.regis',  $refId);
        $tableNumber = $request->input('table_number');
        $qrCodePath = $this->generateQRCode($refId, $redirectUrl, $tableNumber);

        Table::create([
            'reference_id' => $refId,
            'table_number' => $tableNumber,
            'qr_code_path' => $qrCodePath
        ]);

        return redirect()->route('admin.table.index')->with('success', 'Table added successfully!');
    }


    public function downloadQRCode($refId)
    {
        $table = Table::where('reference_id', $refId)->first();
        $tableNumber = $table->table_number;

        $qrCodePath = 'qr_codes/qrcode_' . $refId . '.png';

        if (!Storage::disk('public')->exists($qrCodePath)) {
            abort(404); 
        }

        $fileContent = Storage::disk('public')->get($qrCodePath);

        $filename = 'qrcode_table ' . $tableNumber . '.png';

        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::make($fileContent, 200, $headers);
    }

    public function deleteTable($refId)
    {
        $table = Table::where('reference_id', $refId)->first();

        if (!$table) {
            return redirect()->route('admin.index')->with('error', 'Table not found!');
        }

        $table->delete();

        $qrCodePath = 'qr_codes/qrcode_' . $refId . '.png';
        if (Storage::disk('public')->exists($qrCodePath)) {
            Storage::disk('public')->delete($qrCodePath);
        }

        return redirect()->route('admin.table.index')->with('success', 'Table deleted successfully!');
    }

}
