<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function postLang(Request $request)
    {
        session([
            'locale' => $request->locale,
        ]);

        return redirect()->back();
    }
}
