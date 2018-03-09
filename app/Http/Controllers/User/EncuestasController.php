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
use App\Poll;
use App\Range;
use App\Resume;
use App\MasterAplication;
use App\DetailAplication;
use App\Question;


class EncuestasController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth', ['except' => ['index']]);
    }
   
    public function index()
    {
        $polls = Poll::all();
        return view('user.encuestas.index', compact('polls'));
    }
  
    public function create()
    {
        //  
    }
    
    public function store(Request $request)
    {
        /*if ($request->id_respuestas == null) {
            return redirect()->back()->with('message', 'Debes responder al menos 1pregunta!');
        }*/
        
        //dd($request->all());
        
        $st = Session::get('start_date');
        $master_aplication = new MasterAplication();
        $master_aplication->start_date = $st; 
        $master_aplication->user_id = Auth::user()->id;
        $master_aplication->poll_id = $request->poll_id;;
        $master_aplication->status = 0;
        $master_aplication->save();
        //dd($request->all());        

        $encuesta = Poll::find($request->poll_id);
        $preguntas = Question::where('poll_id', '=', $request->poll_id)->get();
        //$respuestas = Answer::where('poll_id', $encuesta->id)->get();
        $total = 0;

        AplicationPoll::where('user_id', '=', Auth::user()->id)
            ->where('poll_id', '=', $request->poll_id)
            ->delete();

        foreach ($request->id_respuestas as $key => $value) {
            //print_r('llave: '.$key .' valor: '. $value. ' ');
            $aplication_poll = new AplicationPoll();
            $total += Answer::where('id', $value)->first()->value;
            $answer = Answer::find($value);
            $aplication_poll->start = $st;
            $aplication_poll->end = Carbon::now();
            $aplication_poll->value = $answer->value;
            $aplication_poll->user_id = Auth::user()->id;
            $aplication_poll->poll_id = $request->poll_id;
            $aplication_poll->question_id = $answer->question_id;
            $aplication_poll->answer_id = $answer->id;
            $aplication_poll->save();
        }
        //dd($total);        

        //determinar el rango
        //$ranges = null;
        $resume = new \stdClass();
        $resume->text = null;
        $ranges = Range::where('poll_id', '=', $request->poll_id)->get();
        //dd($ranges);
        foreach ($ranges as $key => $value) {
            if ( $total >= $value->from && $total <= $value->to) {
                $range = $value;
                $resume = new Resume();
                $resume->user_id = Auth::user()->id;
                $resume->poll_id = $request->poll_id;
                $resume->total = $total;
                $resume->from = $value->from;
                $resume->to = $value->to;
                $resume->text = $value->text;
                $resume->save();
                //return $resume;
            }
        }
        return view('user.encuestas.resultados.resultado', compact('resume', 'total', 'encuesta'));
    }

    public function individualStore(Request $request)
    {
        if ($request->id_respuestas == null) {
            return redirect()->back()->with('message', 'Debes responder al menos 1 pregunta!');
        }
        
        //dd($request->all());
        
        $st = Session::get('start_date');
        $master_aplication = new MasterAplication();
        $master_aplication->start_date = $st; 
        $master_aplication->user_id = Auth::user()->id;
        $master_aplication->poll_id = $request->poll_id;;
        $master_aplication->status = 0;
        $master_aplication->save();
        //dd($request->all());        

        $encuesta = Poll::find($request->poll_id);
        $preguntas = Question::where('poll_id', '=', $request->poll_id)->get();
        //$respuestas = Answer::where('poll_id', $encuesta->id)->get();
        $total = 0;

        AplicationPoll::where('user_id', '=', Auth::user()->id)
            ->where('poll_id', '=', $request->poll_id)
            ->delete();

        if(isset($request->id_respuestas) && count($request->id_respuestas) > 0)
            foreach ($request->id_respuestas as $key => $value) {
                //print_r('llave: '.$key .' valor: '. $value. ' ');
                $aplication_poll = new AplicationPoll();
                $total += Answer::where('id', $value)->first()->value;
                $answer = Answer::find($value);
                $aplication_poll->start = Carbon::now();
                $aplication_poll->end = Carbon::now();
                $aplication_poll->value = $answer->value;
                $aplication_poll->user_id = Auth::user()->id;
                $aplication_poll->poll_id = $request->poll_id;
                $aplication_poll->question_id = $answer->question_id;
                $aplication_poll->answer_id = $answer->id;
                $aplication_poll->save();
            }

        //determinar el rango

        $resume = new \stdClass();
        $resume->text = null;
        $ranges = Range::where('poll_id', '=', $request->poll_id)->get();

        foreach ($ranges as $key => $value) {
            if ( $total >= $value->from && $total <= $value->to) {
                $range = $value;
                $resume = new Resume();
                $resume->user_id = Auth::user()->id;
                $resume->poll_id = $request->poll_id;
                $resume->total = $total;
                $resume->from = $value->from;
                $resume->to = $value->to;
                $resume->text = $value->text;
                $resume->save();
            }
        }
        return view('user.encuestas.resultados.resultado', compact('resume', 'total', 'encuesta'));
    }
   
    public function show($id)
    {
        $contestadas = null;

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

        if($encuesta->category->timer_type == 2){ // Cuando el tiempo es 
            if ($encuesta->category->show_all_questions == 0) // tiempo por pregunta y mostrar una sola pregunta
                return view('user.encuestas.individual.tiempo_pregunta_individual', compact('encuesta', 'preguntas', 'contestadas', 'numero_preguntas'));
            
            return view('user.encuestas.general.tiempo_pregunta', compact('encuesta', 'preguntas', 'detail_aplication', 'contestadas'));
        }else{
            if ($encuesta->category->show_all_questions == 0) // tiempo por pregunta y mostrar una sola pregunta
                return view('user.encuestas.individual.ajax', compact('encuesta', 'preguntas', 'contestadas', 'numero_preguntas'));

            return view('user.encuestas.general.show', compact('encuesta', 'preguntas', 'detail_aplication', 'contestadas'));
        }
    }

    public function reanudar($id){
        //dd($id);
        $contestadas = AplicationPoll::where('poll_id', '=', $id)
            //->where('user_id', '=', Auth::user()->id)
            ->get();
        //dd($contestadas);
        $encuesta = Poll::find($id);

        $preguntas = Question::where('poll_id', '=', $encuesta->id)
            ->get();
        return view('user.encuestas.general.show', compact('encuesta', 'preguntas', 'contestadas'));

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
}
