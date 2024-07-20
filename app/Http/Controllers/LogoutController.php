<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function __invoke(Request $request): Response
    {
        auth()->user()->tokens()->delete();
        $request->session()->invalidate();
        return response()->noContent();
    }
}
