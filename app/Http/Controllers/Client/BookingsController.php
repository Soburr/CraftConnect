<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function booking()
    {
        return view('client.bookings');
    }
}
