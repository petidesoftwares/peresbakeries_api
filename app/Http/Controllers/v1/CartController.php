<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class CartController extends Controller
{
/**
 * @OA\Get(
 *     path="/carts",
 *     operationId="GetAllCartItems",
 *     tags={"Sales"},
 *     summary="Get all cart items",
 *     description="Get allcart items",
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
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function index()
    {
        $cart = DB::select("select * from cart");
        response()->json(["status" => 200, "data" =>$cart ],200);
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
     *      path="/v1/staff/cart",
     *      operationId="AddToCart",
     *      tags={"Sales"},
     *      summary="Create new cart item",
     *
     *
     *     @OA\RequestBody(
     *         description="Create cart object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateCartModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Cart item Successfully added",
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
        $request->validate([
            "product_id" => "required",
            "quantity" => "required",
            "price" => "required",
            "amount" => "required",
        ]);
        $cart = $request->all();
        Cart::create($cart);
        response()->json(["status" => 200, "message" => "Item added to your cart"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     * 
     * * @OA\Post(
     *      path="/v1/staff/cart/delete/{id}",
     *      operationId="CartDelete",
     *      tags={"Sales"},
     *      summary="Delete a cart from storage",
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful delete operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                example={"message": "Cart successfully deleted"}
     *            )
     *         ),
     *       ),
     *
     *      @OA\Response(response=401, description="Unauthorized"),
     *     security={
     *         {"bearer": {}}
     *     },
     *
     *     )
     */
    public function destroy(string $id)
    {
        Cart::where("id",$id)->delete();
        return response()->json(["status" => 200, "message" => "Item removed successfully"],200);
    }
}
