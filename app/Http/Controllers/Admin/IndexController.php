<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Answer;
use App\Poll;
use App\Category;
use DB;

class IndexController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:admin');
    }
    
    public function home()
    {
        $estadisticas = 123;
        return view('admin.home',compact('estadisticas'));
    }
    
    public function estadisticas()
    {
        /* 
            CANTIDAD DE ENCUESTAS CON RESPUESTAS

        */
        // $respuestas = Answer::where('id', '>', 0)->distinct('poll_id')->pluck('poll_id');
        // $polls = Poll::find($respuestas);
        
        // $estadisticas = 61.3;
        
        // return response()->json([
        //     'name' => 'Informacion y estadisticas. '. date('g:ia \o\n l jS F Y'),
        //     /* 'name' => 'Informacion y estadisticas. '.date("Y-m-d H:i:s"), */
        //     'state' => 'CA',
        //     'estadisticas' => $estadisticas,
        //     'rodolfo' => 100
        // ]);

       
         $total_encuestas_por_categoria = DB::select('select category_id,count(*) Total_Encuestas from polls
                 where category_id in (select id from categories) group by category_id');
            
        foreach ($total_encuestas_por_categoria as $item){
            $catego  = $item->category_id;
            $nomcat =  Category::where('id', '=', $catego)->select("name")->get();
            $tot_enc = $item->Total_Encuestas;
            
       
        }
         dd($nomcat);
        // return response()->json([
        //   'name' => name,
        //   'categoria' => Categoria,
        //   'Total'  => Total_Cat
        // ]);
        

    }
}
