<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(session()->get('admin_login_date')->timestamp);
        //=======================
        // ログイン認証
        //=======================
        $dt = new Carbon();
        //    dd($dt->timestamp);
        //dd(url()->current());
        //dd(route('members.login'));
        $login_date = session('admin_login_date');
        //dd($login_date->timestamp);
        if(!empty($login_date->timestamp)) {
            if(($login_date->timestamp + session('admin_login_limit')) < $dt->timestamp) {
                session()->flush();
                return redirect('/admin');
            } else {
                session()->put('admin_login_date', Carbon::now());
                if (url()->current() === route('admin.login')) {
                    return redirect('/admin');
                }
            }
        } else {
//            dd("ddd");
            if (url()->current() !== route('admin.login')) {
                return redirect('admin/login');
            } elseif(url()->current() === route('admin.login')) {
                return $next($request);
                }
        }
        return $next($request);
    }
}
