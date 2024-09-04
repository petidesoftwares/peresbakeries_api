<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sales;
use App\Models\Expenditure;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getDailyCashBook(){
        $sales = DB::select("select amount from sales where payment_method != 'cash'");//Sales::where("payment_method","!=","cash")->get('amount');
        return response()->json($sales);
        $pdf = Pdf::loadView('dailycashbook')->setPaper('a4','landscape');
        return $pdf->download('Daily Cashbook.pdf');
    }
}
