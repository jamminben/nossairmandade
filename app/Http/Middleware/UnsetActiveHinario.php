<?php
namespace App\Http\Middleware;

use App\Services\GlobalFunctions;
use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class UnsetActiveHinario
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        $requestUrl = Request::getRequestUri();
        $parts = explode('/', $requestUrl);
        if (!in_array($parts[1], [ 'hinario', 'hymn' ])) {
            GlobalFunctions::unsetActiveHinario();
        }

        return $next($request);
    }
}
