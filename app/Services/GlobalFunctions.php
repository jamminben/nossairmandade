<?php
namespace App\Services;

use App\Enums\Languages;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class GlobalFunctions
{
    public static function getCurrentLanguage()
    {
        if (!empty(Cookie::get('lid'))) {
            $languageId = Cookie::get('lid');
        } else {
            $languageId = Languages::ENGLISH;
        }

        return $languageId;
    }

    public static function setCurrentLanguage($languageId)
    {
        Cookie::queue(Cookie::make('lid', $languageId, 365*24*60));

        switch($languageId) {
            case Languages::PORTUGUESE:
                App::setLocale('pt');
                break;
            case Languages::DINGUS:
                App::setLocale('dg');
                break;
            case Languages::ENGLISH:
            default:
                App::setLocale('en');
                break;
        }
    }

    public static function setActiveHinario($hinarioId)
    {
        Cookie::queue(Cookie::make('ahid', $hinarioId, 60));
    }

    public static function unsetActiveHinario()
    {
        Cookie::queue(Cookie::forget('ahid'));
    }

    public static function getActiveHinario()
    {
        if (!empty(Cookie::get('ahid'))) {
            return Cookie::get('ahid');
        } else {
            return null;
        }
    }

    public static function generateUserHinarioCode()
    {
        $base = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $code = '';
        for($i = 0; $i < 12; $i++) {
            $random_character = $base[mt_rand(0, strlen($base) - 1)];
            $code .= $random_character;
        }

        return $code;
    }
}
