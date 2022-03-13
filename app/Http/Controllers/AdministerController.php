<?php

namespace App\Http\Controllers;

use App\Administer;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdministerController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function loginshow()
    {
//        dd(session()->all());

        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string|min:7|max:10',
            'password' => 'required|string|regex:/^[0-9a-zA-Z_\.\-]+$/|min:8|max:20',
        ]);
        $administer = Administer::where('login_id', $request->login_id)->first();
        if(empty($administer)) {
            $errmsg['admin_login'] = "IDもしくはパスワードが間違っています";
            return view('admin.auth.login',[
                'errmsg' => $errmsg,
                'login_id' => $request->login_id
            ]);
        }
//        if(!empty($aminister->deleted_at)) {
//            $errmsg['login'] = "IDもしくはパスワードが間違っています";
//            return view('members.login',['errmsg' => $errmsg]);
//        }
        if($administer->password == $request->password){
            session()->put('admin_login_date', Carbon::now());
            session()->put('admin_login_limit', 60*60);
            session()->put('admin_id', $administer->id);
            session()->put('admin_name', $administer->name);
            return redirect('/admin');
        } else {
            $errmsg['login'] = "IDもしくはパスワードが間違っています";
            return view('admin.auth.login',[
                'errmsg' => $errmsg,
                'login_id' => $request->login_id
            ]);
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect('/admin/login');
    }



    public function membershow(Request $request)
    {

//        dd($request);
        $id = $request->id;
        $male = !empty($request->male) ? $request->male: null;
        $female = !empty($request->female) ? $request->female: null;
        $freeword = $request->freeword;

        $query = Member::query();
        $query->whereNull('deleted_at');
//        dd($male);
        if(empty($id) && empty($male) && empty($female) && empty($freeword)) {
            $members = Member::orderBy('id', 'desc')->whereNull('deleted_at')->paginate(10);
//        dd($members);
            return view('admin.members.show', ['members' => $members]);
        }

        // falseのとき、desc。trueのとき、asc。
        $id_flg = !empty($request->id_flg) ? $request->id_flg: '';
        $created_at_flg = !empty($request->created_at_flg) ? $request->created_at_flg : '';

        if($id_flg == 'asc') {
            $query->orderBy('id', 'asc');
            $id_flg = 'desc';
        } else {
            $query->orderBy('id', 'desc');
            $id_flg = 'asc';
        }

        if($created_at_flg == 'asc') {
            $query->orderBy('created_at', 'asc');
            $created_at_flg = 'desc';
        } else {
            $query->orderBy('created_at', 'desc');
            $created_at_flg = 'asc';
        }


        if(!empty($id)) {
            $query->where('id', $id);
            if(!empty($male)) {
                $query->where('gender', $male);
                if(!empty($female)) {
                    $query->orwhere('gender', $female);
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                } else {
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            } else {
                if(!empty($female)) {
                    $query->where('gender', $female);
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            }
        } else {
            if(!empty($male)) {
                $query->where('gender', $male);
                if(!empty($female)) {
                    $query->orwhere('gender', $female);
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                } else {
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            } else {
                if(!empty($female)) {
                    $query->where('gender', $female);
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                } else {
                    if(!empty($freeword)) {
                        $query->where('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            }
        }
//        dd($query);
        $members = $query->paginate(10);
//        dd($members);
        return view('admin.members.show', [
            'members' => $members,
            'id' => $id,
            'male' => $male,
            'female' => $female,
            'freeword' => $freeword,
            'id_flg' => $id_flg,
            'created_at_flg' => $created_at_flg,
        ]);
//        $members = Member::paginate(10);
////        dd($members);
//        return view('admin.members.show', ['members' => $members]);
    }

    public function memberregister()
    {
        return view('admin.members.edit');
    }
    public function memberregisterconfirm(Request $request)
    {
        $request->validate([
            'name_sei' => 'required|string|max:20',
            'name_mei' => 'required|string|max:20',
            'nickname' => 'required|string|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|string|regex:/^[0-9a-zA-Z_\.\-]+$/|max:20|confirmed',
            'email' => 'required|string|max:200|email|unique:members'
        ]);

        return view('admin.members.edit_confirm', [
            'name_sei' => $request->name_sei,
            'name_mei' => $request->name_mei,
            'nickname' => $request->nickname,
            'gender' => $request->gender,
            'password' => $request->password,
            'email' => $request->email,
            'member_register_flg' => true
        ]);
    }

    public function memberregistercomplete(Request $request, Member $member)
    {
        $member->name_sei = $request->name_sei;
        $member->name_mei = $request->name_mei;
        $member->nickname = $request->nickname;
        $member->gender = $request->gender;
        $member->password = Hash::make($request->password);
        $member->email = $request->email;
        $member->save();

        return redirect('/admin');
    }

    public function membereditshow(Request $request)
    {
        $member = Member::where('id', $request->member_id)->first();
        return view('admin.members.edit', ['member' => $member]);
    }


    public function membereditconfirm(Request $request)
    {
        $targetMember = Member::where('id', $request->id)->first();

        $id = $targetMember->id;

        if(!empty($request->password)) {
            $request->validate([
                'name_sei' => 'required|string|max:20',
                'name_mei' => 'required|string|max:20',
                'nickname' => 'required|string|max:10',
                'gender' => 'required|in:1,2',
                'password' => 'required|string|regex:/^[0-9a-zA-Z_\.\-]+$/|max:20|confirmed',
                'email' => [
                    'required',
                    'string',
                    'max:200',
                    'email',
                    Rule::unique('members')->ignore($request->id, 'id'),
                ],
            ]);

            return view('admin.members.edit_confirm', [
                'name_sei' => $request->name_sei,
                'name_mei' => $request->name_mei,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'password' => $request->password,
                'email' => $request->email,
                'id' => $id,
                'member_register_flg' => false
            ]);

        } else {
            $request->validate([
                'name_sei' => 'required|string|max:20',
                'name_mei' => 'required|string|max:20',
                'nickname' => 'required|string|max:10',
                'gender' => 'required|in:1,2',
                'email' => [
                    'required',
                    'string',
                    'max:200',
                    'email',
                    Rule::unique('members')->ignore($request->id, 'id'),
                ],
            ]);

            return view('admin.members.edit_confirm', [
                'name_sei' => $request->name_sei,
                'name_mei' => $request->name_mei,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'email' => $request->email,
                'id' => $id,
                'member_register_flg' => false
            ]);

        }
    }

    public function membereditcomplete(Request $request)
    {
        if(!empty($request->password)) {
            $member = Member::where('id', $request->id)->first();
            $member->name_sei = $request->name_sei;
            $member->name_mei = $request->name_mei;
            $member->nickname = $request->nickname;
            $member->gender = $request->gender;
            $member->password = Hash::make($request->password);
            $member->email = $request->email;
            $member->save();
            return redirect('admin/members/show');
        } else {
            $member = Member::where('id', $request->id)->first();
            $member->name_sei = $request->name_sei;
            $member->name_mei = $request->name_mei;
            $member->nickname = $request->nickname;
            $member->gender = $request->gender;
            $member->email = $request->email;
            $member->save();
            return redirect('admin/members/show');
        }



    }

}
