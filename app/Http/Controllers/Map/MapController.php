<?php

namespace App\Http\Controllers\Map;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;


class MapController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('map.index');
    }
}
