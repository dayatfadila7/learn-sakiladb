<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
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
