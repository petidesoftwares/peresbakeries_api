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
        $motherArray = ["date"=>$date,];
        if(count($cashSales) >0){
            $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
            $motherArray["cash_sales"] =$cashSales;
        }
        if(couont($bankSales) > 0){
            $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
            $motherArray["bank_sales"] = $cashSales;
        }
        if(count($expenditure) > 0){
            $motherArray["size"] = $util->findLargestArraySize($cashSales, $bankSales, $expenditure);
            $motherArray["expenses"] = $cashSales;
        }
        return $motherArray;
        $pdf = Pdf::loadView('dailycashbook',compact('motherArray'))->setPaper('a4','landscape');
        return $pdf->download('Daily Cashbook.pdf');
    }
}
