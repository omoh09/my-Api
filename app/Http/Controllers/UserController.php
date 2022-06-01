<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $userInfo = User::whereId(1)->get();
            $data = [
                'info' => '',
                'social_media' => '',
                'education',
                'workExperience',
                'skills',
                'Projects',
                'Language',
                'interest',
            ];
            return response()->json([
                'message' => 'success!',
                'data' => $data
            ], 200);
        } catch(Exception $e) {
            return $e->getMessage();
        }
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
            'name' => 'required|min:3',//|unique:projects|max:255',
            'bio' => 'required',
            'password' => 'required',
            'country' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
            'stack' => 'required',
            'philosophy' => 'required',
        ]);
        //dd($validated);
        $user = User::create($validated);
        
        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            $url  = cloudinary()->upload($files->getRealPath(),['folder' => 'omoh'])->getSecurePath();
            if($url){
                $file = $user->files()->create([
                    'project_id' => $user->id,
                    'url' => $url
                ]);
            }
        }
        
        return response()->json([
            'message' => 'success',
            'data' => $user
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
        $data = user::find($id);
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
        $data = User::find($id);
        $data->title = $request->title;
        $data->bio = $request->description;
        //TODO complete the probs
        $data->save();

        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            $url  = cloudinary()->upload($files->getRealPath(),['folder' => 'leo'])->getSecurePath();
            if($url){
                $file = $project->files()->update([
                    'url' => $url
                ])->whereId($id);
            }
        }
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
        $data = User::find($id);
        $data->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ], 200);
    }
}
