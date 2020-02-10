<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    private $langActive = [
        'vi',
        'en',
    ];
    public function changeLang( $lang)
    {
        if (in_array($lang, $this->langActive)) {
            \Session::put('lang', $lang);
            return redirect()->back();
        }
    }
}
