<?php

namespace App\Http\Controllers;

use App\Models\tenderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class tenderFileController extends Controller
{
    public function DeleteFile(String $id){
        $file = tenderFile::find($id);
        $file->delete();
        if (Storage::disk('public')->exists($file->name)) {
            Storage::disk('public')->delete($file->name);
            return back();
        } else {
            return back();
        }
        
    }
}
