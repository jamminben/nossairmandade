<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('show');
    }

    public function update(Request $request)
    {
        return view('show');
    }
}
