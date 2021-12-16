<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Auth\Listeners\SendEmailVerificationNotification;


class UserAcceptController extends Controller
{
    public function index()
    {

        $users = Company::Join('users', 'users.company_id', '=', 'companies.id')->whereIn('users.role', ['free', 'admin', 'new'])->orderBy('users.created_at', 'desc')->get();

        // 必要に応じてここで検索

        return $users;
    }

    public function accept(Request $request)
    {

        $user = User::find($request->user_id);
        $user->accepted = $request->accept;
        $result = $user->save();
        // $result = Company::where('id', $user->company_id)->Join('users', 'users.company_id', '=', 'companies.id')->get();

        if($user->accepted === false){
            // カンパニーを無効に
            $company = Company::where('id', $user->company_id)->first();
            $company->status = 0;
            $company->save();
            // return ['result' => $result, 'result2' => 'result2'];

        } elseif($user->accepted === true and $user->email_verified_at === null) {
            // 承認メール送信
            $user->sendEmailVerificationNotification();
            // カンパニーを有効に
            $company = Company::where('id', $user->company_id)->first();
            $company->status = 1;
            $company->save();
            // return ['result' => $result, 'result3' => 'result3'];

        } elseif($user->accepted === true and isset($user->email_verified_at)) {
            // カンパニーを有効に
            $company = Company::where('id', $user->company_id)->first();
            $company->status = 1;
            $company->save();
            // return ['result' => $result, 'result4' => 'result4'];
        }

        return ['result' => $result];
        // return ['result' => $result, 'result5' => 'result5', 'request' => $user];
    }
}
