<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Files as ExtraFile;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtraFileController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['files'] = Files::orderBy('id', 'desc')->get();
        
        return view('backend.extrafile.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.extrafile.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'file' => 'required',
        ]);
        
        try {
            
            $file = $request->file('file');
            $path = $file->store('files');
            
            $data = new Files();
            $data->file_name = $path;
            $data->created = \Auth::id();
            $data->save();
            
            return redirect()->route('backend.extrafile.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExtraFile $extraFile
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraFile $extraFile) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExtraFile $extraFile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraFile $extraFile) {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ExtraFile    $extraFile
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraFile $extraFile) {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExtraFile $extraFile
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $file = Files::find($id);
        if(isset($file->file_name)) {
            if(Storage::delete($file->file_name)) {
                Files::destroy($file->id);
    
                return redirect()->route('backend.extrafile.index');
            }
        }
    }
}
