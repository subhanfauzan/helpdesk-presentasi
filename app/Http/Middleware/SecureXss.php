<?php

namespace App\Http\Middleware;

use Closure;

class SecureXss
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

        // dd(request()->path(), url()->previous(), get_nama_current_path_root_group());

        if(get_nama_current_path_root_group() == 'issues' || get_nama_current_path_root_group() == 'faq_master'){
            return $next($request);
        } else {
            $input = $request->all();

            array_walk_recursive($input, function(&$input) {

                $input = strip_tags($input);
                $input = str_replace('"', '', $input);
                $input = str_replace("'", "", $input);
                $input = str_replace('<', '', $input);
                $input = str_replace('>', '', $input);

            });

            $request->merge($input);

            return $next($request);
        }
    }
}
