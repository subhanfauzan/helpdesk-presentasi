<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckUserSessionLogin
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
        //https://laracasts.com/discuss/channels/laravel/middleware-to-check-if-session-exists

        // dd($request->session());

        if (!$request->session()->exists('user_app')) {
            // user value cannot be found in session

            // $validateSessionToken = validateSessionToken(Session::get('user_app')['token']);
            // dd($validateSessionToken);

            // if ($validateSessionToken == false) {
            // dd('coba');
            Session::flush();
            return redirect('/');
            // } else {
            // return $next($request);
            // }
        } else {
            $validateSessionToken = validateSessionToken(Session::get('user_app')['token']);
            // dd($validateSessionToken);
            // return $next($request);
            // dd($validateSessionToken);

            if ($validateSessionToken) {
                // return $next($request);
                // $array_url_prefix_dari_session = [];
                // $array_url_prefix_dari_session[] = App::make('url')->to('/' . 'home');

                // $menu = Session::get('user_app')['menu'];
                // // dd($menu);
                // foreach ($menu as $datas => $value) {
                //     for ($i = 0; $i < count($value); $i++) {
                //         // dd(App::make('url')->to('/'.$value[$i]['m_sub_menu_url_sub_menu']));
                //         $ambil_prefix_session = explode('/', $value[$i]['m_sub_menu_url_sub_menu']);
                //         $ambil_prefix_session_fix = $ambil_prefix_session[0];
                //         // dd($ambil_prefix[0]);
                //         $url_prefix_dari_session = App::make('url')->to('/' . $ambil_prefix_session_fix);

                //         $array_url_prefix_dari_session[] = $url_prefix_dari_session;


                //         // dd($request->route()->getPrefix());
                //         // dd($url_prefix_dari_url. ' - ' . $url_prefix_dari_session);
                //         // if ($url_prefix_dari_url == $url_prefix_dari_session || $url_prefix_dari_url == App::make('url')->to('/' . 'home')) {
                //         //     return $next($request);
                //         // } else {
                //         //     dd('hey anda cheater');
                //         // }
                //     }
                // }
                // // dd($array);


                // $ambil_prefix_url_fix = $request->route()->getPrefix();
                // // dd($ambil_prefix_url_fix);
                // $url_prefix_dari_url = App::make('url')->to($ambil_prefix_url_fix);
                // // dd($url_prefix_dari_url);
                // // dd(in_array($url_prefix_dari_url, $array_url_prefix_dari_session));

                // if (in_array($url_prefix_dari_url, $array_url_prefix_dari_session)) {
                return $next($request);
                // } else {
                //     dd('hey anda cheater');
                // }
            } else {
                // dd('coba');
                Session::flush();
                return redirect('/');
            }
        }

        // return $next($request);
    }
}
