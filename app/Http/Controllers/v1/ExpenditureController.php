<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Expenditure;

class ExpenditureController extends Controller
{
/**
 * @OA\Get(
 *     path="/v1/staff/expenditures",
 *     operationId="GetAllExpenditure",
 *     tags={"SalesExpenditure"},
 *     summary="Get all expenditures",
 *     description="Get all expenditures",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "id":1,
 *                          "item": "Flour",
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
        return response()->json(["status"=>200, "data"=>Expenditure::paginate(15)],200);
    }

/**
 * @OA\Get(
 *     path="/v1/staff/list/expenditures",
 *     operationId="GetAllListedExpenditure",
 *     tags={"SalesExpenditure"},
 *     summary="Get all expenditures unpaginated",
 *     description="Get all expenditures unpaginated",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "id":1,
 *                          "item": "Flour",
 *                          "amount": 800,
 *                          "created_at" : "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
public function getExpenditures()
{
    return response()->json(["status"=>200, "data"=>Expenditure::all()],200);
}

        /**
 * @OA\Get(
 *     path="/v1/staff/daily/expenditures",
 *     operationId="GetDailyExpenditure",
 *     tags={"SalesExpenditure"},
 *     summary="Get daily expenditures",
 *     description="Get daily expenditures",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "id":1,
 *                          "item": "Flour",
 *                          "amount": 800,
 *                          "created_at" : "dd/mm/yyyy"
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
public function getDailyExpenditures(Request $request)
{
    $request->validate(["date"=>"required|max:10"]);
    $date = $request->input("date");
    return response()->json(["status"=>200, "data"=>Expenditure::where("created_at","like",$date."%")->get()],200);
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
     *      path="/v1/staff/expenditure",
     *      operationId="CreateExpenditure",
     *      tags={"Expenditure"},
     *      summary="Enter new expenditure",
     *
     *
     *     @OA\RequestBody(
     *         description="Enter Expenditure",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateExpenditureModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Expenditure Successfully registered",
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
        if($user->position == "Manager"){
            $request->validate([
                "item" => "required",
                "amount" => "required"
            ]);

            $expenditure = [
                "item" => $request->input("item"),
                "amount" => $request->input("amount"),
            ];

            Expenditure::create($expenditure);

            return response()->json(["status"=>200, "message"=>"Expenditure successfully registered."],200);
        }
        return response()->json(["status"=>401, "error"=>"Unauthorized access"],401);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Expenditure::where("id",$id)->delete();
        return response()->json(["status"=>200, "message"=>"item removed successfully"],200);
    }
}
