<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Str;

class SalesController extends Controller
{
/**
 * @OA\Get(
 *     path="/v1/staff/sales",
 *     operationId="GetAllSales",
 *     tags={"Sales"},
 *     summary="Get all saled",
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
        return response()->json(["status"=>200, "data"=>Sales::paginate(15)],200);
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
     *      path="/sales",
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
            $salesCart = Cart::all();
            $ref_id = Str::uuid();
            foreach($salesCart AS $item){
                $productObject = [
                    'ref_id' => $ref_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'amount' => $item->amount,
                ];
                Sales::create($productObject);
            }
            event(new SalesNotificationEvent($user->id, "New Sales"));
            return response()->json(["status"=>200, "data"=>Sales::all()],200);
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
    public function GetDailySales(Request $request){
        $dateTime = $request->validate(["dateTime"=>"required|max:20"]);
        $sales = Sales::where("created_at",$dateTime)->get();
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
