<?php

namespace App\Http\Controllers\Reader;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReaderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('reader.index');
    }
}
