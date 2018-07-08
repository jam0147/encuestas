<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\AplicationPoll;
use App\Answer;
use App\Category;
use App\GeneralDefinitions;
use App\Poll;
use App\Range;
use App\Resume;
use App\MasterAplication;
use App\DetailAplication;
use App\Question;

class EncuestaPorGrupoController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth'/*,  ['except' => ['index'] ]*/);
    }
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $encuesta = Poll::find($request->poll_id);
        $preguntas = Question::where('poll_id', '=', $request->poll_id)->get();

        if ($encuesta->category->group_type >0) {
            $group_a_total = 0;
            $group_b_total = 0;
            $group_c_total = 0;
            $group_d_total = 0;

            $grupo_a =0;
            $grupo_b =0;
            $grupo_c =0;
            $grupo_d =0;

            foreach ($request->id_respuestas as $key => $value) {
                //print_r('llave: '.$key .' valor: '. $value. ' ');
                $respuesta = Answer::where('id', $value)->first();
                
                if ($respuesta->group_name == 'a' && $respuesta->value >0) {
                    $grupo_a += 1;
                    $group_a_total = Answer::where('poll_id', $request->poll_id)
                        ->where('group_name', 'a')
                        ->count();
                }
                if ($respuesta->group_name == 'b' && $respuesta->value >0) {
                    $grupo_b += 1;

                    $group_b_total = Answer::where('poll_id', $request->poll_id)
                        ->where('group_name', 'b')
                        ->count();
                }
                if ($respuesta->group_name == 'c' && $respuesta->value >0) {
                    $grupo_c += 1;

                    $group_c_total = Answer::where('poll_id', $request->poll_id)
                        ->where('group_name', 'c')
                        ->count();
                }
                if ($respuesta->group_name == 'd' && $respuesta->value >0) {
                    $grupo_d += 1;

                    $group_d_total = Answer::where('poll_id', $request->poll_id)
                        ->where('group_name', 'd')
                        ->count();
                }
                
            } 
            return " grupo a : " . $grupo_a . " grupo b : " . $grupo_b . " grupo c : " . $grupo_c. " grupo d : " . $grupo_d;

            
        }
    }

  
    public function show($id)
    {
        return "ashow grupos";

        //validar que la encuesta tengas sus rangos
        /*
        select a.poll_id,count(*) from answers a, ranges b 
	        where a.poll_id = b.poll_id and b.`from` > 0 and b.`to` > 0
        */
        $contestadas = null;
        $generaldefinitions = GeneralDefinitions::where('id', '>',0)->first();

        $master_aplication = MasterAplication::where('poll_id', '=', $id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 0)
            ->first();
        
        $encuesta   = Poll::findOrFail($id);
        $preguntas  = Question::where('poll_id', '=', $encuesta->id)->get();
        $detail_aplication = [];

        if ($master_aplication) // si ha guardado la encuesta anteriormente
            $detail_aplication = DetailAplication::where('master_aplication_id', '=', $master_aplication->id)->get();

        Session::put('start_date', Carbon::now()->format('Y-m-d H:i:s'));

        $numero_preguntas = Question::where('poll_id', '=', $encuesta->id)->count();
        //return $encuesta->category->timer_type;
        if($encuesta->category->timer_type == 2){ // Cuando es tiempo por pregunta
            if ($encuesta->category->show_all_questions == 0) 
                //return $generaldefinitions;
                return view('user.encuestas.individual.tiempo_pregunta_individual', compact('encuesta', 'preguntas', 'contestadas', 'numero_preguntas', 'generaldefinitions'));
            
            return view('user.encuestas.general.tiempo_pregunta', compact('encuesta', 'preguntas', 'detail_aplication', 'contestadas', 'generaldefinitions'));
        }else{
            // tiempo por pregunta y mostrar una sola pregunta
            if ($encuesta->category->show_all_questions == 0) 
                //return $generaldefinitions;
                return view('user.encuestas.individual.ajax', compact('encuesta', 'preguntas', 'contestadas', 'numero_preguntas', 'generaldefinitions'));
            //tiempo general
            return view('user.encuestas.general.show', compact('encuesta', 'preguntas', 'detail_aplication', 'contestadas', 'generaldefinitions'));
        }
    }
    
    public function reanudar($id)
    {
        //dd($id);
        $generaldefinitions = GeneralDefinitions::where('id', '>',0)->first();
        $contestadas = AplicationPoll::where('poll_id', '=', $id)
            //->where('user_id', '=', Auth::user()->id)
            ->get();
        //dd($contestadas);
        $encuesta = Poll::find($id);

        $preguntas = Question::where('poll_id', '=', $encuesta->id)
            ->get();
        return view('user.encuestas.grupos.grupos', compact('encuesta', 'preguntas', 'contestadas', 'generaldefinitions'));

    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function desvincular($id, $poll_id)
    {
        //desvincular encuesta de usuario para que no la vuelva a aplicar
        return;
        $poll__users =  DB::table('poll__users')
            ->where('user_id', '=',  $id)
            ->where('poll_id', '=',  $poll_id)
            ->delete();
        
        return;
    }


}
