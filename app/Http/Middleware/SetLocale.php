<?php
namespace App\Http\Middleware;

use App\Services\GlobalFunctions;
use Closure;
use Illuminate\Support\Facades\View;

class SetLocale
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
        $languageId = GlobalFunctions::getCurrentLanguage();

        GlobalFunctions::setCurrentLanguage($languageId);

        View::share ( 'currentLanguage', $languageId );

        return $next($request);
    }
}
