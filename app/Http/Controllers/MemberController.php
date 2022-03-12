<?php

namespace App\Http\Controllers;

use App\Mail\ChangeMemberEmail;
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
            'password' => 'required|string|regex:/\A([a-zA-Z0-9]{8,})+\z/u|max:20',
        ]);
        $member = DB::table('members')->where('email', $validatedData['email'])->first();
        if(empty($member)) {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('members.login',['errmsg' => $errmsg, 'prevEmail' => $request->email]);
        }
        if(!empty($member->deleted_at)) {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('members.login',['errmsg' => $errmsg, 'prevEmail' => $request->email]);
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
            return view('members.login',['errmsg' => $errmsg, 'prevEmail' => $request->email]);
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
            return view('password.confirm',['errmsg' => $errmsg, 'prevEmail' => $request->email]);
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
            'password' => 'required|string|regex:/\A([a-zA-Z0-9]{8,})+\z/u|max:20|confirmed',
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

    public function mypage()
    {
        $id = session()->get('member_id');
        $member = Member::where('id', $id)->first();
//        dd($member);
        return view('members.mypage', ['member' => $member]);
    }

    public function withdrawshow()
    {
        return view('members.withdraw');
    }
    public function withdrawcomplete()
    {
        $member = Member::where('id', session()->get('member_id'))->first();
        $member->deleted_at = Carbon::now();
        $member->save();
        session()->flush();
        return redirect('/');
    }

    public function editmemberinfoshow()
    {
        $member = Member::where('id', session()->get('member_id'))->first();
        return view('members.edit.member_info', ['member' => $member]);
    }
    public function editmemberinfoconfirm(Request $request)
    {
        $validatedData = $request->validate([
            'name_sei' => 'required|string|max:20',
            'name_mei' => 'required|string|max:20',
            'nickname' => 'required|string|max:10',
            'gender' => 'required|in:1,2',
        ]);
        return view('members.edit.member_info_confirm', ['member' => $validatedData]);
    }
    public function editmemberinfocomplete(Request $request)
    {
        $member = Member::where('id', session()->get('member_id'))->first();
        $member->name_sei = $request->name_sei;
        $member->name_mei = $request->name_mei;
        $member->nickname = $request->nickname;
        $member->gender = $request->gender;
        $member->save();
        return redirect('/');
    }

    public function editpasswordshow()
    {
//        $member = Member::where('id', session()->get('member_id'))->first();
        return view('members.edit.member_password');
    }
    public function editpasswordcomplete(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|regex:/\A([a-zA-Z0-9]{8,})+\z/u|max:20|confirmed',
        ]);
        $member = Member::where('id', session()->get('member_id'))->first();
        $member->password = Hash::make($validatedData['password']);
        $member->save();
        return redirect('members/mypage');
    }



    public function editemailshow()
    {
        $member = Member::where('id', session()->get('member_id'))->first();
        return view('members.edit.member_email', ['member' => $member]);
    }
    public function editemailconfirm(Request $request)
    {
        // メール送信
        $validatedData = $request->validate([
            'email' => 'required|string|max:200|email|unique:members'
        ]);
        $member = Member::where('id', session()->get('member_id'))->first();
        $code = "";
        for ($i=0; $i<6; $i++) {
            $code.=mt_rand(0,9);
        }
        $member->auth_code = $code;
        $member->save();
        Mail::send(new ChangeMemberEmail($validatedData['email'], $code));

        return redirect()->route('members.editemailconfirmshow', ['newemail' => $validatedData['email']]);
//        return view('members.edit.member_email_confirm', ['newemail' => $validatedData['email']]);
    }
    public function editemailconfirmshow(Request $request)
    {
        return view('members.edit.member_email_confirm', ['newemail' => $request->newemail]);
    }
    public function editemailcomplete(Request $request)
    {
//        dd($request);

        $validatedData = $request->validate([
            'auth_code' => 'required|regex:/^[0-9]*$/'
        ]);
        $member = Member::where('id', session()->get('member_id'))->first();
        if($member->auth_code == $validatedData['auth_code']) {
            $member->email = $request->newemail;
//            $member->auth_code = "";
            $member->save();
            return redirect('/');
        } else {
            return view('members.edit.member_email_confirm', ['newemail' => $request->newemail, 'err_msg' => '認証コードが違います']);

//            return back();
//            return redirect('members.edit.member_email_confirm', ['newemail' => $request->newemail, 'err_msg' => '認証コードが違います']);
//            return view('members.edit.member_email_confirm', ['newemail' => $request->newemail, 'err_msg' => '認証コードが違います']);
        }

    }
}
