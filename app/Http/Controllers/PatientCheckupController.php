<?php
/*
 * author Arya Permana - Kirin
 * created on 14-12-2024-11h-19m
 * github: https://github.com/KirinZero0
 * copyright 2024
*/

namespace App\Http\Controllers;

use App\Enums\TransactionStatusEnum;
use App\Exports\LaporanBarangExport;
use App\Models\Patient;
use App\Models\PatientCheckup;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductList;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PatientCheckupController extends Controller
{
    public function show(PatientCheckup $patientCheckup)
    {
        $patient = $patientCheckup->patient;
        $transaction = $patientCheckup->transaction;
        $items = $transaction->transactionItems;

        return view('admin.pages.supplier.edit', [
            'transaction' => $transaction,
            'items' => $items,
            'patient'  => $patient
        ]);
    }

    public function update(PatientCheckup $patientCheckup, Request $request)
    {
        $patientCheckup->fill($request->all());
        $patientCheckup->saveOrFail();
    
        return redirect(route('admin.supplier.index'));
    }

    public function destroy(PatientCheckup $patientCheckup)
    {
        $patientCheckup->delete();

        return redirect(route('admin.supplier.index'));
    }
}
