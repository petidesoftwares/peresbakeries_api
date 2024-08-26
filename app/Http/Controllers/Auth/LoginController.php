<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Staff;

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

        $user = Staff::where("mobile_number",$credentials['mobile_number'])->get("id");
        $session = DB::select('select staff_id from sessions where staff_id =?', [$user->id]);
        return response()->json(["session"=>$session]);
        if(count($session) > 0 && $user[0]->id == $session[0]->staff_id){
            return response()->json(['status'=>401, "message"=>"This user already logged"]);
        }
        if($token = Auth::attempt($credentials)){
            if($credentials['mobile_number'] == $credentials['password']){
                DB::insert('insert into sessions (staff_id, ip_address, user_agent) Values (?,?,?)',[$user[0]->id,$request->ip(), $request->header("user_agent")]);
                return $this->firstLoginResponse(auth()->user(), $token);
            }else{
                return $this->responseWithToken(auth()->user(), $token);
            }
        }
        return response()->json(['error'=>'Unauthorized Login'],401);

    }
}
