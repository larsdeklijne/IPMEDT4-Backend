<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;

use App\User;

use Illuminate\Support\Facades\Auth;

use Validator, Input, Redirect, Hash;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

class ComplaintsController extends Controller
{
    public function index()
    {
        $complaints = Complaint::orderBy('id', 'desc')->get();;

        return response()->json([
            $complaints
        ]);
    }

    public function show($complaint)
    {
        $complaint_tuple = Complaint::where('id', '=', $complaint)->first();

        return response()->json([
            $complaint_tuple
        ]);
    }

    public function store($train_name, $name, $email, $complaint)
    {

        $requestComplaint = array(
            'train_name' => $train_name,
            'name' => $name,
            'email' => $email,
            'complaint' => $complaint);

        json_encode($requestComplaint);

        $validator = Validator::make($requestComplaint, [
            'train_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'complaint' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $complaint = Complaint::create([
            'train_name' => htmlentities($train_name),
            'name' => htmlentities($name),
            'email' => htmlentities($email),
            'complaint' => htmlentities($complaint),
        ]);


        return response()->json(compact('complaint'), 201);

        $complaint -> save();
    }

    public function toggle($id, $toggle_value) {
        $complaint_tuple_toggle = Complaint::find($id);
        $complaint_tuple_toggle->update(['is_completed' => (int) $toggle_value]);
    }


}
