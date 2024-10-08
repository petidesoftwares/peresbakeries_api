<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Events\SalesNotificationEvent;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Expenditure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use Illuminate\Support\Str;

use App\Analytics\DataAnalysis;

class SalesController extends Controller
{
/**
 * @OA\Get(
 *     path="/v1/staff/sales",
 *     operationId="GetAllSales",
 *     tags={"Sales"},
 *     summary="Get all sales",
 *     description="Get all sales",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "product_id":"xxxxxxxxxxx",
 *                          "quantity": 4,
 *                          "price": 200,
 *                          "amount": 800,
 *                          "payment_method": "pos",
 *                          "created_at" : "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function index()
    {
        return response()->json(["status"=>200, "data"=>Sales::with("soldproduct")->paginate(15)],200);
    }

/**
 * @OA\Get(
 *     path="/v1/staff/query/sales",
 *     operationId="GetAllSalesByAdmin",
 *     tags={"Sales"},
 *     summary="Get all sales",
 *     description="Get all sales",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "product_id":"xxxxxxxxxxx",
 *                          "quantity": 4,
 *                          "price": 200,
 *                          "amount": 800,
 *                          "soldby": {
 *                                     "id": "xxxxxxxxxxxxxxxxx",
 *                                      "surname":"Oritz",
 *                                      "firstname":"Roderick",
 *                                      "mobile_number":"08010000000",
 *                                      "position":"HRM",
 *                                      "address":"No. 8 Yabrifa Close, Kpansia, Yenagoa",
 *                                      "gender":"Male",
            *                          "date_of_birth":"01-01-2000",
            *                      },
*                           "payment_method": "pos",
 *                          "created_at" : "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */

    public function getSalesByAdmin(){
        return response()->json(["status"=>200, "data"=>Sales::with("soldBy")->with("soldproduct")->paginate(15)],200);
    }

    /**
 * @OA\Get(
 *     path="/v1/staff/all/sales",
 *     operationId="GetAllSalesByAdmin",
 *     tags={"Sales"},
 *     summary="Get all sales",
 *     description="Get all sales",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "product_id":"xxxxxxxxxxx",
 *                          "quantity": 4,
 *                          "price": 200,
 *                          "amount": 800,
 *                          "soldby": {
 *                                     "id": "xxxxxxxxxxxxxxxxx",
 *                                      "surname":"Oritz",
 *                                      "firstname":"Roderick",
 *                                      "mobile_number":"08010000000",
 *                                      "position":"HRM",
 *                                      "address":"No. 8 Yabrifa Close, Kpansia, Yenagoa",
 *                                      "gender":"Male",
            *                          "date_of_birth":"01-01-2000",
            *                      },
*                           "payment_method": "pos",
 *                          "created_at" : "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */

    public function getAllSalesByAdmin(){
        return response()->json(["status"=>200, "data"=>Sales::with("soldBy")->with("soldproduct")->get()],200);
    }

    public function aggregatedSales(){
        $sales = DB::table("sales")->select(DB::raw('ref_id, created_at, COUNT(product_id) AS products'))->groupBy('ref_id','created_at')->orderBy('created_at','desc')->paginate(15);
        return response()->json(["status"=>200, "data"=>$sales]);
    }

    public function refSales($ref_id){
        return response()->json(['status'=>200, 'data'=> Sales::where('ref_id',$ref_id)->with("soldby")->with("soldproduct")->get()],200);
    }


    public function progressiveBarChartData(){
        // $user = Auth::user();
        $categories = ["Soft Drinks", "Bread", "Confectionaries","Energy Drinks", "Wines", "Alcoholic"];
        $motherChart = [];
        foreach($categories as $category){
            $salesData = DB::table("sales")
            ->join('products', 'products.id','=','sales.product_id' )
            ->select(DB::raw('products.name,sales.product_id, COUNT(sales.product_id) AS quantity_sold'))->where('products.category',$category)->groupBy('sales.product_id','products.name')->orderBy('sales.product_id','desc')->get();
            $barChartData =[["Products", "Sales"]];
            foreach($salesData as $data){
                $sales = array();
                $sales[] = $data->name;
                $sales[] = $data->quantity_sold; 
                $barChartData[] = $sales;
             }
             $motherChart[$category.''] = $barChartData;
        }
        return response()->json(["status"=>200, "data"=>$motherChart]);
    }

    public function progressivePieChartData(){
        $analytics = new DataAnalysis();
        $revenue = DB::table("sales")->select(DB::raw('SUM(amount) AS revenue'))->get();
        $expenditure = DB::table('expenditures')->select(DB::raw('SUM(amount) AS expenditure'))->get();
        $profit = intval($revenue[0]->revenue)-intval($expenditure[0]->expenditure); 
        $dataArray = ["expenditure"=>$analytics->calculatePieDataSector(intval($expenditure[0]->expenditure), [$profit,intval($expenditure[0]->expenditure)]), "profit"=>$analytics->calculatePieDataSector($profit, [$profit,intval($expenditure[0]->expenditure)])];
        return response()->json(['status'=>200, 'data'=> $dataArray],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

        /**
     * @OA\Post(
     *      path="/v1/staff/sales",
     *      operationId="InitiateSales",
     *      tags={"Sales"},
     *      summary="Make new sales",
     *
     *
     *     @OA\RequestBody(
     *         description="Create sales object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateSaleModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Sales item Successfully created",
     *       ),
     *
     *      @OA\Response( response=422, description="Unproccessable data",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *              example={"error": "Unproccessable data"},
     *            )
     *         ),
     *     ),
     *     security={
     *         {"bearer": {}}
     *     },
     *
     *     )
     */                                                                            
    public function store(Request $request)
    {
        $user = Auth::user();
        if($user->position == "Sales"){
            $request->validate(["salesObj"=>"required", "payment_method"=>"required"]);
            $salesData = $request->input("salesObj");
            $paymentMethod = $request->input("payment_method");
            $ref_id = Str::uuid();
            foreach($salesData as $item){
                    $productObject=[
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'amount' => $item['amount'],
                    ];   
                              
                $productObject['ref_id'] = $ref_id;
                $productObject['staff_id'] = $user->id;
                $productObject['payment_method']=$paymentMethod;
                Sales::create($productObject);
                $stock = Product::where("id",$productObject["product_id"])->get("stock");
                Product::where("id", $productObject["product_id"])->update(["stock"=> $stock[0]->stock - $productObject["quantity"]]);
                // Cart::truncate();
            }
            event(new SalesNotificationEvent($user->id, "New Sales"));
            return response()->json(["status"=>200, "data"=>Sales::where("ref_id",$ref_id)->get()],200);
        }
        return response()->json(["status"=>401, "error"=>"Unathorized access"],401);       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

/**
 * @OA\Get(
 *     path="/v1/staff/sales/{date}",
 *     operationId="GetDailySales",
 *     tags={"Sales"},
 *     summary="Get daily sales",
 *     description="Get daily sales",
 * 
 *      @OA\RequestBody(
 *         description="Daily sales request object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateDailySaleModel")
 *     ),
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "product_id":"xxxxxxxxxxx",
 *                          "quantity": 4,
 *                          "price": 200,
 *                          "amount": 800,
 *                          "created_at": "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function getDailySales(Request $request){
        $date = $request->validate(["date"=>"required|max:10"]);

        $sales = Sales::where("created_at","like",$date["date"]."%")->get();
        return response()->json(["status"=>200, "data" => $sales],200);
    }

    /**
 * @OA\Get(
 *     path="/v1/staff/sales/range",
 *     operationId="GetSalesRange",
 *     tags={"Sales"},
 *     summary="Get sales range",
 *     description="Get sales range",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "product_id":"xxxxxxxxxxx",
 *                          "quantity": 4,
 *                          "price": 200,
 *                          "amount": 800,
 *                          "created_at": "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
public function GetSalesRange(Request $request){
    $user = Auth::user();
    if($user->position == "CEO"){
        $request->validate([
            "start_date" => "required",
            "end_date" => "required"
        ]);
        $sales = Sales::where("created_at",$request->input("start_date"))->where("created_at","<=",$request->input("end_date"))->get();
        return response()->json(["status"=>200, "data" => $sales],200);
    }
    return response()->json(["status" => 401, "message" => "Unauthorized request"],200);
}

public function getDailyReport(Request $request){
    $user = Auth::user();
    if($user->position == "CEO"){
        $request->validate(["date"=>"required|max:10"]);

        $out = Sales::where("created_at", "like",$request->input("date")."%")->get();
        $in = Product::Where("created_at", "like", $request->input("date")."%")->get();

        return response()->json(["status"=>200, "data"=>["soldout"=>$out, "addedproducts"=>$in]],200);
    }
    return response()->json(["status"=>401, "message"=>"Unauthorized access"],401);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
