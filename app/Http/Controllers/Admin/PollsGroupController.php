<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Poll;
use App\Category;
use App\AplicationPoll;
use App\Question;
use App\Answer;
use App\Range;


class PollsGroupController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        //
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $categories = Category::all();
        $poll = Poll::findOrFail($id);
        $questions = Question::where('poll_id', '=', $id)->get();
        $groups_numbers = (Question::where('poll_id', '=', $id)->count()) / 4;
        //dd($groups_numbers);
        if ( $groups_numbers == 0 ) { $groups_numbers = "x"; }
        
        return view('admin.polls_group.edit',compact('poll', 'categories', 'questions', 'groups_numbers'));
    }

    public function add( $count, $poll_id )
    {
        if ($count == "x") 
        {
            $count = 1;
        }else{
            $count++;
        }

        $poll = Poll::find($poll_id);

        for ($i=1; $i <= 4; $i++) { 
            //return $i;
            if ($i == 1) {
                $group_name = "a";
            }
            if ($i == 2) {
                $group_name = "b";
            }
            if ($i == 3) {
                $group_name = "c";
            }
            if ($i == 4) {
                $group_name = "d";
            }
            $question = Question::create([
                'name' => 'pregunta ' . $count . '.' . $group_name,
                'poll_id' => $poll_id, 
                'multiple_answers' => 0,
                'group_name' => $group_name,
                'group_number' => $count,
            ]);

            $answer_yes =  Answer::create([
                'name' => 'Mas',
                'value' => 1,
                'question_id' => $question->id,
                'poll_id' => $poll_id,
                'group_name' => $group_name
            ]);
            $answer_not =  Answer::create([
                'name' => 'Menos',
                'value' => 0,
                'question_id' => $question->id,
                'poll_id' => $poll_id,
                'group_name' => $group_name

            ]);
        }
        //agregar y verificar q tenga rango        
        $rango =  Range::firstOrCreate([
            'from' => 1,
            'to' => 1,
            'text' => 'grupo a tu pesonalidaddd',
            'poll_id' => $poll->id,
        ]);
        $rango =  Range::firstOrCreate([
            'from' => 2,
            'to' => 2,
            'text' => 'grupo b tu pesonalidaddd',
            'poll_id' => $poll->id,
        ]);
        $rango =  Range::firstOrCreate([
            'from' => 3,
            'to' => 3,
            'text' => 'grupo c tu pesonalidaddd',
            'poll_id' => $poll->id,
        ]);
        $rango =  Range::firstOrCreate([
            'from' => 4,
            'to' => 4,
            'text' => 'grupo d tu pesonalidaddd',
            'poll_id' => $poll->id,
        ]);
        
        return redirect()->route('polls-group.edit', ['id' => $poll_id]);
        
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
