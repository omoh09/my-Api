<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\FileResource;
use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use App\Helpers\Helper;
use App\Models\Project;
use App\Models\File;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = ProjectResource::collection(Project::all());
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
        $request->validate([
            'title' => 'required|unique:projects|max:255',
            'description' => 'required',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description
        ]);
        
        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            $url  = cloudinary()->upload($files->getRealPath(),['folder' => 'leo'])->getSecurePath();
            if($url){
                $file = $project->files()->create([
                    'project_id' => $project->id,
                    'url' => $url
                ]);
            }
        }
        
        return response()->json([
            'message' => 'success',
            'data' => $project
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
        $data = Project::find($id);
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
        $data = Project::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
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
        $data = Project::find($id);
        $data->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ], 200);
    }
}
