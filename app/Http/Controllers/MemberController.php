<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Member;
use Illuminate\Http\Request;
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
        // TODO ログイン保持
        return redirect()->route('members.regist');
    }
}
