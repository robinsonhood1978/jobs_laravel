<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Note;
use Validator;
use App\Http\Resources\NoteResource;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // error_log(json_encode($request->fullUrl()));
        $input = $request->all();
        error_log(json_encode($input['jobId']));
        $notes = Note::where('job_id', $input['jobId'])->where('user_id', $request->user()->id)->get();
    
        return $this->sendResponse(NoteResource::collection($notes), 'Notes retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // error_log($request->user()->id);
        // error_log(auth()->user()->id);
        // return $this->sendResponse($input, 'Note retrieved successfully.');
        error_log(json_encode($input));
   
        $validator = Validator::make($input, [
            'content' => 'required',
            'job_id' => 'required',
            // 'user_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $note = Note::create($input + ['user_id' => $request->user()->id]);
   
        return $this->sendResponse(new NoteResource($note), 'Note created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);
  
        if (is_null($note)) {
            return $this->sendError('Note not found.');
        }
   
        return $this->sendResponse(new NoteResource($note), 'Note retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'content' => 'required',
            'job_id' => 'required',
            'user_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $note->content = $input['content'];
        $note->job_id = $input['job_id'];
        $note->user_id = $input['user_id'];
        $note->save();
   
        return $this->sendResponse(new NoteResource($note), 'Note updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
   
        return $this->sendResponse([], 'Note deleted successfully.');
    }
}
