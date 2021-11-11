<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    protected function verify(VerificationRequest $request)
    {
        try {
            $input = $request->all();
            if ($input['check_code']==$input['verification_code']) {
                tap(User::where('phone', $input['phone']))->update(['isVerified' => true]);
                return redirect(route('users.profile'))->with([ 'successcodeverif' => __('lang.success_code_verification')]);
            }
            return back()->with([ 'errorcodeverif' => __('lang.error_code_verification')]);
        }
        catch(\Exception $e){
            return $e;
        }

    }
}
