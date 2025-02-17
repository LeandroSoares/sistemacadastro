<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class MeusDadosController extends Controller
{
    public function index()
    {
        return view('pages.meus-dados', [
            'user' =>  Auth::user()
        ]);
    }
}
