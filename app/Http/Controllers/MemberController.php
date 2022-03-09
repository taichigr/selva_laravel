<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            return view('index');
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
        return redirect('index');
    }
}
