<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class MemberAuth
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
//        dd(session()->get('login_date')->timestamp);
        //=======================
        // ログイン認証
        //=======================
        $dt = new Carbon();
        //    dd($dt->timestamp);
        //dd(url()->current());
        //dd(route('members.login'));
        $login_date = session('login_date');
        //dd($login_date->timestamp);
        if(!empty($login_date->timestamp)) {
            if(($login_date->timestamp + session('login_limit')) < $dt->timestamp) {
                session()->flush();
                return redirect('/');
            } else {
                session()->put('login_date', Carbon::now());
                if (url()->current() === route('members.login')) {
                    return redirect('/');
                } elseif (url()->current() === route('members.regist')) {
                    return redirect('/');
                }
            }
        } else {
            if(url()->current() === route('members.regist')) {
                $next($request);
            } elseif (url()->current() !== route('members.login')) {
                return redirect('members/login');
            }
        }
        return $next($request);
    }
}
