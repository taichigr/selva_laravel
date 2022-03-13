<?php

namespace App\Http\Controllers;

use App\Administer;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                } else {
                    if(!empty($freeword)) {
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            } else {
                if(!empty($female)) {
                    $query->where('gender', $female);
                    if(!empty($freeword)) {
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
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
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                }
            } else {
                if(!empty($female)) {
                    $query->where('gender', $female);
                    if(!empty($freeword)) {
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
                        $query->orwhere('name_mei', 'like', '%'.$freeword.'%');
                        $query->orwhere('email', 'like', '%'.$freeword.'%');
                    }
                } else {
                    if(!empty($freeword)) {
                        $query->orwhere('name_sei', 'like', '%'.$freeword.'%');
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
}
