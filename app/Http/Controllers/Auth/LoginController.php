<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends AuthController
{
    public const GUARD = "staff";

    public function __construct(){
        parent::__construct(LoginController::GUARD);
    }

    /**
     * @OA\Post(
     *      path="/staff/login",
     *      operationId="stafflogin",
     *      tags={"Staff"},
     *      summary="Staff login",
     *
     *
     *     @OA\RequestBody(
     *         description="Staf login object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StaffLoginModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful login operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 example={
     *                              "login_type":"string", 
     *                              "token":"string",
     *                              "admin":{
     *                                          "id":"string",
     *                                          "surname": "string",
     *                                          "firstname": "string",
     *                                          "mobile_number": "number",
     *                                          "position": "string",
     *                                          "address": "string",
     *                                          "gender": "string",
     *                                          "dob": "string",
     *                                          "creared_at":"string"
     *                                      },
     *                              "token_type":"bearer", 
     *                              "expires_in":"string"
     *                          }
     *            )
     *         ),
     *       ),
     *
     *      @OA\Response( response=401, description="Unauthorized",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *              example={"error": "Unauthorized"},
     *            )
     *         ),
     *     ),
     *     security={
     *         {"bearer": {}}
     *     },
     *
     *     )
     */

    public function login(Request $request){
        $request->validate([
            'mobile_number'=>'bail|required|min:11|regex:/^([0-9\s\-\+\(\)]*)$/',
            'password'=>'required|min:6'
        ]);

        $credentials = [
            'mobile_number' => $request->input("mobile_number"),
            'password' => $request->input("password"),
        ];
        return $credentials;

        if($token = Auth::attempt($credentials)){
            if($credentials['mobile_number'] == $credentials['password']){
                return $this->firstLoginResponse(auth()->user(), $token);
            }else{
                return $this->responseWithToken(auth()->user(), $token);
            }
        }
        return response()->json(['error'=>'Unauthorized Login'],401);

    }
}
