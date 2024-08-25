<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $guardName;

    public function guard(){
        return Auth::guard($this->guardName);
    }

    public function __construct($guardName){
        $this->guardName = $guardName;
        Auth::shouldUse($this->guardName);
    }

    
     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function me(){
        return response()->json(['status'=>200, 'data'=>Auth::guard($this->guardname)->user()]);
     }
    
     /**
     * 
     * * @OA\Post(
     *      path="/v1/staff/logout",
     *      operationId="Stafflogout",
     *      tags={"Staff"},
     *      summary="Deauthenticate a staff",
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful logout operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                example={"message": "Successfully logged out"}
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

     public function logout(){
        $user = Auth::guard($this->guardName)->user();
        DB::delete('delete from sessions where staff_id = ?', [$user->id]);
        Auth::guard($this->guardName)->logout();
        return response()->json(["status"=>200, "data"=>"User successfully logged out"]);
     }

    /**
     * @OA\Post(
     *      path="staff/refresh/{user-type}",
     *      operationId="staffrefresh",
     *      tags={"Staff"},
     *      summary="Refresh staff token after expiration",
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful token refresh",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                example={
     *                          { 
     *                              "token":"string", 
     *                              "user":{
     *                                      "surname": "string",
     *                                      "firstname": "string",
     *                                      "gender": "string",
     *                                      "phone_number": "number",
     *                                      "address": "string",
     *                                      "position": "string",
     *                                      "dob": "string",
     *                                  },
     *                              "token_type":"bearer", 
     *                              "expires_in":"string"
     *                              }
     *                       }
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
     *
     */
     public function refresh($user_type){
        return $this->responseWithToken(Auth::guard($this->guardName)->user(), Auth::guard($this->guardName)->refresh(), $user_type);
     }
/**
     * @OA\Post(
     *      path="staff/firstlogin",
     *      operationId="staffFirstLogin",
     *      tags={"Staff"},
     *      summary="Login staff token after expiration. Note: user-type is ceo, manager or sales.",
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful first login",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                example={
     *                          { 
     *                              "login_type':'first",
     *                              "token":"string", 
     *                              "user":{
     *                                      "surname": "string",
     *                                      "firstname": "string",
     *                                      "gender": "string",
     *                                      "phone_number": "number",
     *                                      "address": "string",
     *                                      "position": "string",
     *                                      "dob": "string",
     *                                  },
     *                              "token_type":"bearer", 
     *                              "expires_in":"string"
     *                              }
     *                       }
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
     *
     */
     public function firstLoginResponse($user, $token){
        return response()->json([
            'status'=>200,
            'login_type'=>'first',
            'token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 1
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithToken($user, $token)
    {
        return response()->json([
            'status'=>200,
            'login_type'=>'updated user',
            'token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 1
        ]);
    }
}
