<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Question::paginate(10);
        return view('new.questions.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = Question::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'location' => $request['location']
        ]);
        if ($request['options'] !== [null]) {
            foreach ($request['options'] as $key => $value) {
                Option::create([
                    'question_id' => $query->id,
                    'title' => $value
                ]);
            }
        }

        return redirect('questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Question::find($id);

        $options = Option::where('question_id', $id)->get();

        return view('new.questions.edit', compact('id','model','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Question::find($id)->delete();

        $query = Question::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'location' => $request['location']
        ]);
        if ($request['options'] !== [null]) {
            foreach ($request['options'] as $key => $value) {
                Option::create([
                    'question_id' => $query->id,
                    'title' => $value
                ]);
            }
        }

        return redirect('questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::find($id)->delete();
        return redirect('questions');

    }
}
