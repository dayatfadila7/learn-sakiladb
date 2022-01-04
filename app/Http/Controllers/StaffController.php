<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group B. Stores Staffs
 *
 * APIs for Stores Staffs
 **/

class StaffController extends Controller
{
    /**
     * Add Data Actor to Film
     *
     * @urlParam id integer ID Actor. Example: 1
     * @bodyParam first_name string required This is a first name staff. Example: sherina
     * @bodyParam last_name string required This is a last name staff. Example: shina
     * @bodyParam email string This is a email staff. Example: shina.sherina@gmail.com
     * @bodyParam username string required This is a username staff. Example: shinasherina
     * @bodyParam password string required This is a username staff. Example: &L1s@blacp1nk
     * @bodyParam address_id integer required This is a id address. Example: 1
     * @bodyParam strore_id integer required This is a id store. Example: 2
     * @bodyParam picture string required This is a  picture staff.
     * @response
     * {
     * "message": "OK, Success to save data",
     * }
     *
     * @response status=401 {
     *      "message": "Failed to save data",
     * }
     */
    public function addStaffStore(Request $request, $id)
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "email|unique:staff,email",
            'username' => "required|unique:staff,username",
            'password' => 'required',
            'address_id' => 'required|integer|exists:address,address_id',
            'store_id' => 'required|integer|exists:store,store_id',
        ];

        $this->validate($request, $rules);

        $staff = new Staff;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->address_id = $request->address_id;
        $staff->picture = $request->picture;
        $staff->email = $request->email;
        $staff->store_id = $id;
        $staff->username = $request->username;
        $staff->password = Hash::make($request->password); //validation hash
        $staff->last_update = Carbon::now();

        if ($staff->save()) {
            return response()->json([
                'message' => 'OK, Success to save data',
            ]);
        }
        return response()->json([
            'message' => 'Failed to save data',
        ], 401);

    }
}
