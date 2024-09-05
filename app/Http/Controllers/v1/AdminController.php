<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sales;
use App\Models\Expenditure;
use App\Analytics\Util;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getDailyCashBook(Request $request){
        $request->validate(["date"=>"required|max:10"]);
        $date = $request->input('date');
        $bankSales = Sales::where("payment_method","!=","Cash")->where('created_at',$date)->get('amount');
        $cashSales = Sales::where("payment_method","=","Cash")->where('created_at',$date)->get('amount');
        $expenditure = Expenditure::where("created_at",$date)->get("amount");
        $util = new Util();
        return response()->json($util->findLargestArraySize($cashSales, $bankSales, $expenditure));
        $motherArray = [
            "date"=>$date,
            "cash_sales"=>$cashSales,
            "bank_sales"=>$bankSales,
            "expenses"=>$expenditure
        ];
        $pdf = Pdf::loadView('dailycashbook')->setPaper('a4','landscape');
        return $pdf->download('Daily Cashbook.pdf');
    }
}
