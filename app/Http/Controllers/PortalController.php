<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PortalController extends Controller
{
    public function index()
    {
        return view('portal.index');
    }
}
