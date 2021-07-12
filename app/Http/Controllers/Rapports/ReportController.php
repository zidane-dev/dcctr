<?php

namespace App\Http\Controllers\Rapports;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use App\Models\Upload;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ReportController extends Controller
{
    public function index()
    {
        $files= Upload::all();
        return view('uploads.rapports', compact('files'));
    }

    public function create()
    {
        return view('uploads.new_rapport');

    }

    public function store(UploadRequest $request)
    {
        try{
            if($request->hasFile('file')){
                $file = $request->file('file');
                $nameWithExt = $file->getClientOriginalName();
                $name = pathinfo($nameWithExt, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                // $link = public_path('files');
                $file_name = $name.'_'.time().'.'.$ext;
                $file->storeAs('public/files', $file_name);
                Upload::create([
                    'filename'=> $file_name,
                    'id_user' =>Auth::user()->id,
                    'titre_ar'=>$request->champ_ar,
                    'titre_fr'=>$request->champ_fr,
                ]);
                Session::flash('success', __('uploads.success'));
            }else{
                Session::flash('error', __('uploads.error'));
            }
        }catch(Throwable $t){
            Session::flash('error', __('uploads.exception'));
            Log::error($t);
        }
        
        return redirect()->back();
    }

    public function destroy($id)
    {
        $upload = Upload::find($id);
        Storage::delete($upload->filename);
    }

}
