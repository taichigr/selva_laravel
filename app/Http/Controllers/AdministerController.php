<?php

namespace App\Http\Controllers;

use App\Administer;
use App\Member;
use App\Product_category;
use App\Product_subcategory;
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

        $id_flg = !empty($request->id_flg) ? $request->id_flg: '';
        $created_at_flg = !empty($request->created_at_flg) ? $request->created_at_flg : '';
//        dd($request);
        $id = $request->id;
        $male = !empty($request->male) ? $request->male: null;
        $female = !empty($request->female) ? $request->female: null;
        $freeword = $request->freeword;

        $query = Member::query();
        $query->whereNull('deleted_at');
//        dd($male);
        if(empty($id) && empty($male) && empty($female) && empty($freeword)) {

            if(empty($id_flg) && empty($created_at_flg)){
                $members = Member::orderBy('id','desc')->paginate(10);
                return view('admin.members.show', [
                    'members' => $members
                ]);
            } else {

                $query = Member::query();
                if($id_flg == 'asc') {
                    $query->orderBy('id', 'asc');
                    $id_flg = 'desc';
                } elseif($id_flg == 'desc') {
                    $query->orderBy('id', 'desc');
                    $id_flg = 'asc';
                }

                if($created_at_flg == 'asc') {
                    $query->orderBy('created_at', 'asc');
                    $created_at_flg = 'desc';
                } elseif($created_at_flg == 'desc') {
                    $query->orderBy('created_at', 'desc');
                    $created_at_flg = 'asc';
                }
                $members = $query->paginate(10);
                return view('admin.members.show', [
                    'members' => $members,
                    'id' => $id,
                    'male' => $male,
                    'female' => $female,
                    'freeword' => $freeword,
                    'id_flg' => $id_flg,
                    'created_at_flg' => $created_at_flg,
                ]);
            }

            $members = Member::orderBy('id', 'desc')->whereNull('deleted_at')->paginate(10);
//        dd($members);
            return view('admin.members.show', ['members' => $members]);
        }



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


    public function memberdetailshow(Request $request)
    {
        $member = Member::where('id', $request->member_id)->first();
        return view('admin.members.detail', ['member' => $member]);
    }

    public function memberdelete(Request $request)
    {
        $member = Member::where('id', $request->member_id)->first();
        $member->deleted_at = Carbon::now();
        $member->save();
        return redirect('admin/members/show');
    }



    //=========================
    // 商品関連
    //=========================
    public function productscategoryshow(Request $request)
    {
        $id_flg = !empty($request->id_flg) ? $request->id_flg: '';
        $created_at_flg = !empty($request->created_at_flg) ? $request->created_at_flg : '';

        $product_category_id = $request->product_category_id;
        $freeword = $request->freeword;

        $query = Product_category::query();

        if(empty($product_category_id) && empty($freeword)) {
            if(empty($id_flg) && empty($created_at_flg)){
                $product_categories = $query
                    ->orderBy('id','desc')
                    ->paginate(10);
                return view('admin.products.category_show', [
                    'product_categories' => $product_categories
                ]);
            } else {
                if($id_flg == 'asc') {
                    $query->orderBy('product_categories.id', 'asc');
                    $id_flg = 'desc';
                } else {
                    $query->orderBy('product_categories.id', 'desc');
                    $id_flg = 'asc';
                }

                if($created_at_flg == 'asc') {
                    $query->orderBy('created_at', 'asc');
                    $created_at_flg = 'desc';
                } else {
                    $query->orderBy('created_at', 'desc');
                    $created_at_flg = 'asc';
                }

                $product_categories = $query->paginate(10);
                return view('admin.products.category_show', [
                    'product_categories' => $product_categories,
                    'product_category_id' => $product_category_id,
                    'freeword' => $freeword,
                    'id_flg' => $id_flg,
                    'created_at_flg' => $created_at_flg
                ]);
            }
        }

        if($id_flg == 'asc') {
            $query->orderBy('product_categories.id', 'asc');
            $id_flg = 'desc';
        } else {
            $query->orderBy('product_categories.id', 'desc');
            $id_flg = 'asc';
        }

        if($created_at_flg == 'asc') {
            $query->orderBy('product_categories.created_at', 'asc');
            $created_at_flg = 'desc';
        } else {
            $query->orderBy('product_categories.created_at', 'desc');
            $created_at_flg = 'asc';
        }

        if(!empty($product_category_id)) {
            $query->where('id', $product_category_id);
            if(!empty($freeword)) {
                $query->join('product_subcategories', 'product_categories.id', '=', 'product_subcategories.product_category_id');
                $query->orWhere('product_categories.name', 'like', '%'.$freeword.'%');
                $query->orWhere('product_subcategories.name', 'like', '%'.$freeword.'%');
//                $query->groupBy('product_categories.name');
            }
        } else {
            if(!empty($freeword)) {
                $query->join('product_subcategories', 'product_categories.id', '=', 'product_subcategories.product_category_id');
                $query->orWhere('product_categories.name', 'like', '%'.$freeword.'%');
                $query->orWhere('product_subcategories.name', 'like', '%'.$freeword.'%');
//                $query->groupBy('product_categories.name');
            }
        }

        $product_categories = $query
            ->select('product_categories.*')->distinct()
            ->paginate(10);
//        dd($product_categories);
        return view('admin.products.category_show', [
            'product_categories' => $product_categories,
            'product_category_id' => $product_category_id,
            'freeword' => $freeword,
            'id_flg' => $id_flg,
            'created_at_flg' => $created_at_flg
        ]);
    }

    public function productscategoryregister()
    {
        return view('admin.products.category_edit');
    }

    public function productscategoryedit(Request $request)
    {
        $product_category = Product_category::where('id', $request->product_category_id)->first();
        $product_subcategories = Product_subcategory::where('product_category_id', $request->product_category_id)->get();

        return view('admin.products.category_edit', [
            'product_category' => $product_category,
            'product_subcategories' => $product_subcategories,
            'edit_flg' => true
        ]);
    }

    public function productscategoryregisterconfirm(Request $request)
    {
        $request->validate([
            'product_category_name' => 'required|max:20|unique:product_categories,name',
            'product_subcategory_name1' => 'required|string|max:20',
            'product_subcategory_name2' => 'max:20',
            'product_subcategory_name3' => 'max:20',
            'product_subcategory_name4' => 'max:20',
            'product_subcategory_name5' => 'max:20',
            'product_subcategory_name6' => 'max:20',
            'product_subcategory_name7' => 'max:20',
            'product_subcategory_name8' => 'max:20',
            'product_subcategory_name9' => 'max:20',
            'product_subcategory_name10' => 'max:20',
        ]);

        return view('admin.products.category_edit_confirm', [
            'product_category_name' => $request->product_category_name,
            'product_subcategory_name1' => $request->product_subcategory_name1,
            'product_subcategory_name2' => $request->product_subcategory_name2,
            'product_subcategory_name3' => $request->product_subcategory_name3,
            'product_subcategory_name4' => $request->product_subcategory_name4,
            'product_subcategory_name5' => $request->product_subcategory_name5,
            'product_subcategory_name6' => $request->product_subcategory_name6,
            'product_subcategory_name7' => $request->product_subcategory_name7,
            'product_subcategory_name8' => $request->product_subcategory_name8,
            'product_subcategory_name9' => $request->product_subcategory_name9,
            'product_subcategory_name10' => $request->product_subcategory_name10,
        ]);
    }

    public function productscategoryeditconfirm(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required',
            'product_category_name' => 'required|max:20',
            'product_subcategory_name1' => 'required|string|max:20',
            'product_subcategory_name2' => 'max:20',
            'product_subcategory_name3' => 'max:20',
            'product_subcategory_name4' => 'max:20',
            'product_subcategory_name5' => 'max:20',
            'product_subcategory_name6' => 'max:20',
            'product_subcategory_name7' => 'max:20',
            'product_subcategory_name8' => 'max:20',
            'product_subcategory_name9' => 'max:20',
            'product_subcategory_name10' => 'max:20',
        ]);

        return view('admin.products.category_edit_confirm', [
            'product_category_id' => $request->product_category_id,
            'product_category_name' => $request->product_category_name,
            'product_subcategory_name1' => $request->product_subcategory_name1,
            'product_subcategory_name2' => $request->product_subcategory_name2,
            'product_subcategory_name3' => $request->product_subcategory_name3,
            'product_subcategory_name4' => $request->product_subcategory_name4,
            'product_subcategory_name5' => $request->product_subcategory_name5,
            'product_subcategory_name6' => $request->product_subcategory_name6,
            'product_subcategory_name7' => $request->product_subcategory_name7,
            'product_subcategory_name8' => $request->product_subcategory_name8,
            'product_subcategory_name9' => $request->product_subcategory_name9,
            'product_subcategory_name10' => $request->product_subcategory_name10,
            'edit_flg' => true
        ]);
    }

    public function productscategoryregistercomplete(Request $request, Product_category $product_category)
    {
        $product_category->name = $request->product_category_name;
        $product_category->save();
        $product_category_id = $product_category->id;


        $product_subcategory1 = new Product_subcategory;
        $product_subcategory1->name = $request->product_subcategory_name1;
        $product_subcategory1->product_category_id = $product_category_id;
        $product_subcategory1->save();

        if(!empty($request->product_subcategory_name2)) {
            $product_subcategory2 = new Product_subcategory;
            $product_subcategory2->name = $request->product_subcategory_name2;
            $product_subcategory2->product_category_id = $product_category_id;
            $product_subcategory2->save();
        }
        if(!empty($request->product_subcategory_name3)) {
            $product_subcategory3 = new Product_subcategory;
            $product_subcategory3->name = $request->product_subcategory_name3;
            $product_subcategory3->product_category_id = $product_category_id;
            $product_subcategory3->save();
        }
        if(!empty($request->product_subcategory_name4)) {
            $product_subcategory4 = new Product_subcategory;
            $product_subcategory4->name = $request->product_subcategory_name4;
            $product_subcategory4->product_category_id = $product_category_id;
            $product_subcategory4->save();
        }
        if(!empty($request->product_subcategory_name5)) {
            $product_subcategory5 = new Product_subcategory;
            $product_subcategory5->name = $request->product_subcategory_name5;
            $product_subcategory5->product_category_id = $product_category_id;
            $product_subcategory5->save();
        }
        if(!empty($request->product_subcategory_name6)) {
            $product_subcategory6 = new Product_subcategory;
            $product_subcategory6->name = $request->product_subcategory_name6;
            $product_subcategory6->product_category_id = $product_category_id;
            $product_subcategory6->save();
        }
        if(!empty($request->product_subcategory_name7)) {
            $product_subcategory7 = new Product_subcategory;
            $product_subcategory7->name = $request->product_subcategory_name7;
            $product_subcategory7->product_category_id = $product_category_id;
            $product_subcategory7->save();
        }
        if(!empty($request->product_subcategory_name8)) {
            $product_subcategory8 = new Product_subcategory;
            $product_subcategory8->name = $request->product_subcategory_name8;
            $product_subcategory8->product_category_id = $product_category_id;
            $product_subcategory8->save();
        }
        if(!empty($request->product_subcategory_name9)) {
            $product_subcategory9 = new Product_subcategory;
            $product_subcategory9->name = $request->product_subcategory_name9;
            $product_subcategory9->product_category_id = $product_category_id;
            $product_subcategory9->save();
        }
        if(!empty($request->product_subcategory_name10)) {
            $product_subcategory10 = new Product_subcategory;
            $product_subcategory10->name = $request->product_subcategory_name10;
            $product_subcategory10->product_category_id = $product_category_id;
            $product_subcategory10->save();
        }
        return redirect('admin/products/category/show');
    }

    public function productscategoryeditcomplete(Request $request)
    {
        $product_category = Product_category::where('id', $request->product_category_id)->first();
        $product_category->name = $request->product_category_name;
        $product_category->save();
        $product_category_id = $product_category->id;


        $product_subcategory1 = new Product_subcategory;
        $product_subcategory1->name = $request->product_subcategory_name1;
        $product_subcategory1->product_category_id = $product_category_id;
        $product_subcategory1->save();

        if(!empty($request->product_subcategory_name2)) {
            $product_subcategory2 = new Product_subcategory;
            $product_subcategory2->name = $request->product_subcategory_name2;
            $product_subcategory2->product_category_id = $product_category_id;
            $product_subcategory2->save();
        }
        if(!empty($request->product_subcategory_name3)) {
            $product_subcategory3 = new Product_subcategory;
            $product_subcategory3->name = $request->product_subcategory_name3;
            $product_subcategory3->product_category_id = $product_category_id;
            $product_subcategory3->save();
        }
        if(!empty($request->product_subcategory_name4)) {
            $product_subcategory4 = new Product_subcategory;
            $product_subcategory4->name = $request->product_subcategory_name4;
            $product_subcategory4->product_category_id = $product_category_id;
            $product_subcategory4->save();
        }
        if(!empty($request->product_subcategory_name5)) {
            $product_subcategory5 = new Product_subcategory;
            $product_subcategory5->name = $request->product_subcategory_name5;
            $product_subcategory5->product_category_id = $product_category_id;
            $product_subcategory5->save();
        }
        if(!empty($request->product_subcategory_name6)) {
            $product_subcategory6 = new Product_subcategory;
            $product_subcategory6->name = $request->product_subcategory_name6;
            $product_subcategory6->product_category_id = $product_category_id;
            $product_subcategory6->save();
        }
        if(!empty($request->product_subcategory_name7)) {
            $product_subcategory7 = new Product_subcategory;
            $product_subcategory7->name = $request->product_subcategory_name7;
            $product_subcategory7->product_category_id = $product_category_id;
            $product_subcategory7->save();
        }
        if(!empty($request->product_subcategory_name8)) {
            $product_subcategory8 = new Product_subcategory;
            $product_subcategory8->name = $request->product_subcategory_name8;
            $product_subcategory8->product_category_id = $product_category_id;
            $product_subcategory8->save();
        }
        if(!empty($request->product_subcategory_name9)) {
            $product_subcategory9 = new Product_subcategory;
            $product_subcategory9->name = $request->product_subcategory_name9;
            $product_subcategory9->product_category_id = $product_category_id;
            $product_subcategory9->save();
        }
        if(!empty($request->product_subcategory_name10)) {
            $product_subcategory10 = new Product_subcategory;
            $product_subcategory10->name = $request->product_subcategory_name10;
            $product_subcategory10->product_category_id = $product_category_id;
            $product_subcategory10->save();
        }
        return redirect('admin/products/category/show');
    }



}
