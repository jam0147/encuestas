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
        
        // $respuestas = Answer::where('id', '>', 0)->distinct('poll_id')->pluck('poll_id');
        // $polls = Poll::find($respuestas);
        
        // $estadisticas = 61.3;
        
        // ************************************************************************************
        // Total encuestas por categorias
        $total_encuestas_por_categoria = DB::table('polls')
            ->select('polls.category_id','categories.name',DB::raw('count(*) as tot_enc'))
            ->join("categories","categories.id","=","polls.category_id")
            ->groupBy('polls.category_id','categories.name')
            ->get();
         
         $total_encuestas = 0;
         foreach ($total_encuestas_por_categoria as $item){
            $catego  = $item->category_id;
            //$nomcat =  Category::where('id', '=', $catego)->select("name")->get();
            $nomcat = $item->name;
            $tot_enc = $item->tot_enc;
            $total_encuestas += $tot_enc;
        } 
        
        //*************************************************************************** */
        // Total encuestas sin valorizacion (Ranges)
        $total_encuestas_sin_rangos = DB::table('polls')
               ->select('polls.category_id','categories.name', DB::raw('COUNT(*) as tot_enc_sin_rango'))
                ->whereNotIn('polls.id',function($query){
                   $query->select('ranges.poll_id')->from('ranges');
                })
                ->join("categories","categories.id","=","polls.category_id")
                ->groupBy('polls.category_id','categories.name')
                ->get();

        $total_encuestas = 0;
        foreach ($total_encuestas_sin_rangos as $items) {
            $catego  = $items->category_id;
            $nomcat =  $items->name;
            $tot_enc = $items->tot_enc_sin_rango;
            $total_encuestas += $tot_enc;
        }
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //dd($total_encuestas_sin_rangos);
        return response()->json([
            'total_encuestas_por_categoria' => $total_encuestas_por_categoria,
            'total_encuestas_sin_rangos' => $total_encuestas_sin_rangos,
        ], 200);
    
       

    }
}
