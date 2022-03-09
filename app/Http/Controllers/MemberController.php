<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

use App\Http\Requests\MemberRequest;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    //
    public function regist()
    {
        $gender = config('master.gender');
        $prefectures = config('master.prefectures');
        return view("members.regist", ["prefectures" => $prefectures, "gender" => $gender]);
    }

    public function confirm(MemberRequest $request, Member $member)
    {
        $member->fill($request->all());
        return view('members.regist_confirm', ['member' => $member]);
    }

    public function complete(Request $request, Member $member)
    {
        $member->fill($request->all());
        $member->password = Hash::make($member->password);
        $member->save();

        session()->put('login_date', Carbon::now());
        session()->put('login_limit', 60*60);
        session()->put('member_id', $member->id);
        session()->put('name_sei', $member->name_sei);
        session()->put('name_mei', $member->name_mei);
        // TODO ログイン保持
        return view('members.regist_complete');
    }
    public function loginshow()
    {
        return view('members.login');
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|max:200|email',
            'password' => 'required|string|min:8|max:20',
        ]);
        $member = DB::table('members')->where('email', $validatedData['email'])->first();
        if(empty($member)) {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('members.login',['errmsg' => $errmsg]);
        }
        if(Hash::check($validatedData['password'], $member->password)){
            session()->put('login_date', Carbon::now());
            session()->put('login_limit', 60*60);
            session()->put('member_id', $member->id);
            session()->put('name_sei', $member->name_sei);
            session()->put('name_mei', $member->name_mei);
            return redirect('/');
        } else {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('members.login',['errmsg' => $errmsg]);
        }
    }
    public function index()
    {
        return view('index');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function showPasswordConfirmForm()
    {
        return view('password.confirm');
    }
    public function passwordConfirmSend(Request $request)
    {
        // ここでは、パスワード再設定メールを送信
        $validatedData = $request->validate([
            'email' => 'required|string|max:200|email',
        ]);
//        dd($validatedData);
        $member = DB::table('members')->where('email', $validatedData['email'])->first();
        if(empty($member)) {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('members.login',['errmsg' => $errmsg]);
        }
        $token = Str::random(30);
        session()->put('password_token', $token);
        session()->put('email', $member->email);
        $url = route('password.checktoken', ['token' => $token]);
        Mail::send(new ResetPasswordMail($member, $url));
        return view('password.sent_page');
    }

    public function passwordConfirmCheckToken(Request $request)
    {
        if(session()->get('password_token') === $request->token){
            return view('password.update');
        }
    }
    public function passwordUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:8|max:20|confirmed',
        ]);
        DB::table('members')
            ->where('email', session()->get('email'))
            ->update(['password' => Hash::make($validatedData['password'])]);
        $member = DB::table('members')->where('email', session()->get('email'))->first();
//        dd($member);
        session()->flush();
        session()->put('login_date', Carbon::now());
        session()->put('login_limit', 60*60);
        session()->put('member_id', $member->id);
        session()->put('name_sei', $member->name_sei);
        session()->put('name_mei', $member->name_mei);
        return redirect('/');

    }
}
