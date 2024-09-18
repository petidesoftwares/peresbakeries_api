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
        $bankSales = Sales::where("payment_method","!=","Cash")->where('created_at','like',$date."%")->get('amount');
        $cashSales = Sales::where("payment_method","=","Cash")->where('created_at','like',$date."%")->get('amount');
        $expenditure = Expenditure::where("created_at","like",$date."%")->get("amount");
        $util = new Util();
        $totalCashSales = 0;
        $totalBankSales = 0;
        $totalExpenses = 0;
        $motherArray = ["date"=>$date,];
        if(count($cashSales) >0 || count($bankSales) > 0 || count($expenditure) > 0){
            if(count($cashSales) >0){
                $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
                $motherArray["cash_sales"] =$cashSales;
                foreach($cashSales as $sales_1){
                    $totalCashSales += $sales_1->amount;
                }
                $motherArray["total_cash_sales"] = $totalCashSales;
            }
            if(count($bankSales) > 0){
                $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
                $motherArray["bank_sales"] = $bankSales;
                foreach($bankSales as $sales_2){
                    $totalBankSales += $sales_2->amount;
                }
                $motherArray["total_bank_sales"] = $totalBankSales;
            }
            if(count($expenditure) > 0){
                $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
                $motherArray["expenses"] = $expenditure;
                foreach($expenditure as $expense){
                    $totalExpenses += $expense->amount;
                }
            }
            $motherArray["total_expenses"] = $totalExpenses;
            $pdf = Pdf::loadView('dailycashbook',compact('motherArray'))->setPaper('a4','landscape');
            return $pdf->download('Daily Cashbook.pdf');
        }else{
            return response()->json(['status'=>200, 'message' => "No sales Sales or expenditure today"]);
        }
        
    }
}
