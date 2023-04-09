<?php  

namespace App\Http\Middleware;  
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware; 
use Closure; 
use Auth;  

class VerifyCsrfToken extends Middleware {

    public function handle($request, Closure $next)
    {
        if($request->route()->named('logout')) {
            if (auth()->check()) {
                auth()->logout();
            }

            return redirect('/');
        }
    
        return parent::handle($request, $next);
    }
}