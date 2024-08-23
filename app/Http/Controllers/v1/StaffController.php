<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

class StaffController extends Controller
{
/**
 * @OA\Get(
 *     path="/v1/staff/staffs",
 *     operationId="GetAllStaff",
 *     tags={"Staff"},
 *     summary="Get all staffs",
 *     description="Get all staffs",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                      {
 *                          "surname":"Oritz",
 *                          "firstname":"Roderick",
 *                          "mobile_number":"08010000000",
 *                          "position":"HRM",
 *                          "address":"No. 8 Yabrifa Close, Kpansia, Yenagoa",
 *                          "gender":"Male",
 *                          "date_of_birth":"01-01-2000",
 *                      },
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function index()
    {
        return response()->json(['status'=>200, 'data'=>Staff::paginate(15)],200);
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
     *      path="v1/staff/staff",
     *      operationId="StaffUpload",
     *      tags={"Staff"},
     *      summary="Create new staff",
     *
     *
     *     @OA\RequestBody(
     *         description="Create Staff object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateStaffModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Staff Successfully created",
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
        if($user->position == "CEO"){
            $validator = Validator::make([
                'firstname'=>$request->input('firstname'),
                'surname'=>$request->input('surname'),
                'gender'=>$request->input('gender'),
                'mobile_number'=>$request->input('mobile_number'),
                'position'=>$request->input('position'),
                'address'=>$request->input('address'),
                'dob'=>$request->input('dob')
            ], [
                'firstname'=>'required|min:3|max:50',
                'surname'=>'required|min:3|max:50',
                'gender'=>'required|min:4|max:6',
                'mobile_number' => "required|min:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:staff,mobile_number",
                'position'=>'required',
                'address' => 'required',
                'dob' => 'required',
            ]);
    
            $validator->validate();
            
            if($request->input('position') != "CEO"){
                $checkManager = Staff::where("position","Manager")->first();
                if($request->input('position') == "Manager" && !empty($checkManager)){
                    return response()->json(['status'=>300, "message"=>"Manager already exist"],300);
                }
                $staff = [
                    'firstname'=>$request->input('firstname'),
                    'surname'=>$request->input('surname'),
                    'gender'=>$request->input('gender'),
                    'mobile_number'=>$request->input('mobile_number'),
                    'position'=>$request->input('position'),
                    'address'=>$request->input('address'),
                    'dob'=>$request->input('dob'),
                    'password'=>Hash::make($request->input('mobile_number')),
                ];
        
                $created = Staff::create($staff);
        
                return response()->json(['status'=>200, "data"=> $created, 'message'=>'Staff created successfuly.'],200);
            }
            return response()->json(["status"=>300, "message"=>"Position already taken"],300);    
            
        }
        

    }

    /**
 * @OA\Get(
 *     path="/v1/staff/staff/{id}",
 *     operationId="GetStaff",
 *     tags={"Staff"},
 *     summary="Get staff details",
 *     description="Get staff details",
 * 
 *     @OA\Response(
 *              response="200", 
 *              description="Successful",
 *              @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *              example={
 *                          "surname":"Oritz",
 *                          "firstname":"Roderick",
 *                          "mobile_number":"08010000000",
 *                          "position":"HRM",
 *                          "address":"No. 8 Yabrifa Close, Kpansia, Yenagoa",
 *                          "gender":"Male",
 *                          "date_of_birth":"01-01-2000",
 *                  },
 *            )
 *         ),
 *     )
 * )
 */
    public function show(string $id)
    {
        return response()->json(['status'=>200, 'data'=>Staff::where('id',$id)->get(),200]);
    }
   
    public function edit(string $id)
    {
       
    }

    /**
     * @OA\Post(
     *      path="/v1/staff/update/{id}",
     *      operationId="StaffUpdate",
     *      tags={"Staff"},
     *      summary="Update staff details",
     *
     *
     *     @OA\RequestBody(
     *         description="Update Staff object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateStaffModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Staff Record Successfully updated",
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
        $editedData = $request->all();

        if($request->input("firstname") != null && $request->input("firstname") != ""){
            $request->validate(["firstname"=>"min:3|max:50"]);
        }
        if($request->input("surname") != null && $request->input("surname") != ""){
            $request->validate(["surname"=>"min:3|max:50"]);
        }
        if($request->input("gender") != null && $request->input("gender") != ""){
            $request->validate(["gender"=>"min:4|max:6"]);
        }
        if($request->input("mobile_number") != null && $request->input("mobile_number") != ""){
            $request->validate(["mobile_number"=>"min:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:staff,mobile_number"]);
        }

        Staff::where("id", $id)->update($editedData);

        return response()->json(["status"=>200, "message"=>"Staff successfully updated"],200);
    }

        /**
     * @OA\Post(
     *      path="v1/staff/password/update",
     *      operationId="UpdateStaffPassword",
     *      tags={"Staff"},
     *      summary="Update user psaaword at first login",
     *
     *
     *     @OA\RequestBody(
     *         description="Update password object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatedPasswordModel")
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Password Successfully Updated",
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
    public function updatePassword(Request $request){
        $user = auth()->user();
        $request->validate(["newpassword" => "required|min:8"]);
        $newPassword = $request->input("newpassword");
        Staff::where("id", $user->id)->update(["password" => $newPassword]);
        return response()->json(['status'=>200, "message" => "password sucessfully updated"], 200);
    }

    /**
     * 
     * * @OA\Post(
     *      path="/v1/staff/delete/{id}",
     *      operationId="StaffDelete",
     *      tags={"Staff"},
     *      summary="Delete a staff from storage",
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
     *                example={"message": "Staff successfully deleted"}
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
        Staff::where("id",$id)->delete();
    }
}
