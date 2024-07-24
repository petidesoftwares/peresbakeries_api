<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
/**
 * @OA\Get(
 *     path="/v1/staff/products",
 *     operationId="GetAllProducts",
 *     tags={"Product"},
 *     summary="Get all products",
 *     description="Get all products",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "name":"Jumbo",
 *                          "price": 1000,
 *                          "description": "Jumbo size bread",
 *                          "shape": "cuboid",
 *                          "size": "10cm X 10cm X 25cm",
 *                          "stock": 500,
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function index()
    {
        return response()->json(["status"=>200, "data"=>Product::paginate(15)]);
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
     *      path="/v1/staff/product",
     *      operationId="ProductUpload",
     *      tags={"Product"},
     *      summary="Create new product",
     *
     *
     *     @OA\RequestBody(
     *         description="Create Product object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateProductModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Product Successfully created",
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
        $product = [
            "name" => $request->input("name"),
            "price" => $request->input("price"),
            "description" => $request->input("description"),
            "shape" => $request->input("shape"),
            "size" => $request->input("size"),
            "stock" => $request->input("stock"),
        ];
        $validator = Validator::make($product,[
            "name" => "required|max:25",
            "price" => "required|digits:6",
            "description" => "required",
            "stock" => "required| digits:6"
        ]);
        $validator->validate();
        Product::create($product);
        return response()->json(["status"=>200, "message"=>"Product successfully created"],200);
    }

  /**
 * @OA\Get(
 *     path="/v1/staff/product/{id}",
 *     operationId="GetAProduct",
 *     tags={"Product"},
 *     summary="Get product",
 *     description="Get product",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                          "name":"Jumbo",
 *                          "price": 1000,
 *                          "description": "Jumbo size bread",
 *                          "shape": "cuboid",
 *                          "size": "10cm X 10cm X 25cm",
 *                          "stock": 500,
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function show(string $id)
    {
        return response()->json(["status"=>200, "data"=>Product::where("id",$id)->get()],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/v1/staff/product/update/{id}",
     *      operationId="ProductUpdate",
     *      tags={"Product"},
     *      summary="Update product details",
     *
     *
     *     @OA\RequestBody(
     *         description="Update product object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateProductModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Product Record Successfully updated",
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
    public function update(Request $request, string $id)
    {
        $editedProduct = $request->all();
        $validate = Validator::make($editedProduct,[
            "name" => "max:25",
            "price" => "digits:6",
            "stock" => "digits:6",
        ]);
        $validator->validate();
        Product::where("id", $id)->update($editedProduct);
        return response()->json(["status"=>200, "message"=>"Product record successfully updated"],200);
    }

 /**
     * 
     * * @OA\Post(
     *      path="/v1/staff/product/delete/{id}",
     *      operationId="ProductDelete",
     *      tags={"Staff"},
     *      summary="Delete a product from storage",
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
     *                example={"message": "Product successfully deleted"}
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
        Product::where("id", $id)->delete();
        return response()->json(["status" => 200, "message" => "Product successfully deleted"],200);
    }
}
