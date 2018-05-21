<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function home()
    {
        $estadisticas = 123;
        return view('admin.home',compact('estadisticas'));
    }
    
    public function estadisticas()
    {
        $estadisticas = 61.3;
        return response()->json([
            'name' => 'Informacion y estadisticas. '. date('g:ia \o\n l jS F Y'),
            /* 'name' => 'Informacion y estadisticas. '.date("Y-m-d H:i:s"), */
            'state' => 'CA',
            'estadisticas' => $estadisticas
        ]);
    }
}
