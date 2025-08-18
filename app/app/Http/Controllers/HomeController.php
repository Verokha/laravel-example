<?php

namespace App\Http\Controllers;

class HomeController
{
    public function home()
    {
        return response()->json([
            'success' => true
        ], 200);
    }
}
