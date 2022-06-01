<?php

namespace App\Http\Controllers;

use App\Models\skills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required,|unique:skills',
            'rating' => 'int',
            'user_id' => 1,
        ]);
        //dd($validated);
        $skills = skills::create($validated);
        
        return response()->json([
            'message' => 'skill added successfully',
            'data' => $skills
        ]);      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = skills::find($id);

        return response()->json([
            'message' => 'success!',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = skills::find($id);
        $data->title = $request->title;
        $data->rating = $request->rating;
        $data->save();

        return response()->json([
            'message' => 'successfully updated!',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = skills::find($id);
        $data->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ], 200);
    }
}
