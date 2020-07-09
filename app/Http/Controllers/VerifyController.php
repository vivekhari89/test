<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyController extends Controller
{
	public function index()
    {
        return view('auth.verifyotp');
    }
    public function verify(Request $request)
    {
        try {
            $data = $request->validate([
                'verification_code' => ['required', 'numeric'],
            ]);
            // $authy_api = new AuthyApi(getenv("AUTHY_SECRET"));
            // $res = $authy_api->verifyToken(auth()->user()->authy_id, $data['verification_code']);
            $res = false;
            // dd(\session('otp') ,$data['verification_code'] );
            if(\session('otp') == $data['verification_code']) $res = true;
            if ($res) {
                \session(['isVerified' => true]);
                return redirect()->route('home');
            }
            return back()->with(['error' => 'Wrong otp']);
            // return back()->with(['error' => $res->errors()->message]);
        } catch (\Throwable $th) {
            return back()->with(['error' => $th->getMessage()]);
        }
    }
    
}
