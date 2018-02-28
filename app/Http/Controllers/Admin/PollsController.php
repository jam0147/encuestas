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


class PollsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $polls = Poll::all();
        return view('admin.polls.index',compact('polls'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('admin.polls.create', compact('categories'));        
    }

    
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required' ]);

        $poll = Poll::create($request->all());

        Session::flash('message', 'poll added!');
        Session::flash('status', 'success');

        return redirect('admin/polls');

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
        
        return view('admin.polls.edit',compact('poll', 'categories', 'questions'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required' ]);

        $polls = Poll::findOrFail($id);
        $polls->update($request->all());

        Session::flash('message', 'Poll updated!');
        Session::flash('status', 'success');

        return redirect('admin/polls');
    }

    
    public function destroy($id)
    {
        $polls = Poll::findOrFail($id);
        //en caso de no poder editar y/o eliminar
        //dd($polls);
        $encuestas_aplicadas = AplicationPoll::where('poll_id', '=', $polls->id)->get();
        $encuestas_aplicadas = AplicationPoll::where('poll_id', '=', $polls->id)->first();
        if (! $encuestas_aplicadas == null) {
            return redirect()->back()->with('message', 'Debido a que hay encuestasaplicadas, no puedes editar o eliminar!');
        }

        $polls->delete();

        Session::flash('message', 'Poll deleted!');
        Session::flash('status', 'success');

        return redirect('admin/polls');
    }
}
