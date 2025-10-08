<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function artisan()
    {
        return view('client.artisan');
    }
}
