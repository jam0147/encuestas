<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Poll;
use App\Range;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class RangeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $polls = Poll::all();
        return view('admin.ranges.index', compact('polls'));
    }

  
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //return $request->all();
        //dd( $request->all());
        $rules = array (
                    'from' => 'required',
                    'to' => 'required',
                    'text' => 'required',
            );
        $validator = Validator::make ( Input::all (), $rules );
        if ($validator->fails ())
            return Response::json ( array (
                'errors' => $validator->getMessageBag ()->toArray ()
            ) );
        else {
            $data = new Range ();
            $data->from = $request->from;
            $data->to = $request->to;
            $data->text = $request->text;
            $data->poll_id = $request->poll_id;
            $data->save ();
            return response ()->json ( $data );
        }
    }

   
    public function show($id)
    {
         //return $id;
         $poll = Poll::find($id);
         $ranges = Range::where('poll_id', '=', $poll->id)
             ->get();
         
         return view('admin.ranges.show', compact('poll', 'ranges'));
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
