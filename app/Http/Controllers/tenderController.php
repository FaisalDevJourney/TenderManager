<?php

namespace App\Http\Controllers;

use App\Models\tender;
use App\Models\tenderFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class tenderController extends Controller
{
    public function index(){
        $tenders = tender::latest()->paginate(5);
        return view('home',compact('tenders'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function createTender(Request $request){
        $request->validate([
            'Name' => 'required',
            'client' => 'required',
            'contractor'=> 'required'
        ]);
        tender::create($request->all());

       return redirect('/');

    }

    public function show(String $id){
       $tender = tender::find($id);
        return view('edittender',compact('tender'));
    }

    public function uploadDocuments(Request $request, String $id){
        
        
        $tender_documents = [];
        $technicals = [];
        $commercials = [];
        if ($request->file('TD')){
            foreach($request->file('TD') as $key => $tender_document)
            {
                $file_name = time().$tender_document->getClientOriginalName().'.'.$tender_document->extension();  
                $tender_document->move(public_path('storage'), $file_name);
                $tender_documents[]['name'] = $file_name;
            }
        }

        foreach ($tender_documents as $key => $tender_document) {
            tenderFile::create([
                    'name'=>$tender_document['name'],
                    'tender_id'=>$id,
                    'type'=>'Tender Documents'
            ]);
        }
        if ($request->file('Technical')){
            foreach($request->file('Technical') as $key => $technical)
            {
                $file_name = time().$technical->getClientOriginalName().'.'.$technical->extension();  
                $technical->move(public_path('storage'), $file_name);
                $technicals[]['name'] = $file_name;
            }
        }

        foreach ($technicals as $key => $technical) {
            tenderFile::create([
                    'name'=>$technical['name'],
                    'tender_id'=>$id,
                    'type'=>'Technical'
            ]);
        }
        if ($request->file('Commercial')){
            foreach($request->file('Commercial') as $key => $commercial)
            {
                $file_name = time().$commercial->getClientOriginalName().'.'.$commercial->extension();  
                $commercial->move(public_path('storage'), $file_name);
                $commercials[]['name'] = $file_name;
            }
        }

        foreach ($commercials as $key => $commercial) {
            tenderFile::create([
                    'name'=>$commercial['name'],
                    'tender_id'=>$id,
                    'type'=>'Commercial'
            ]);
        }
        return back();
    }

    public function update(Request $request, String $id){
        tender::find($id)->update($request->all());
        return redirect("/");
    }

    public function preview(String $id){
        $tender = tender::find($id);
        $technical = tenderFile::where('tender_id','=',$id)->where('type', '=','Technical')->paginate(5, ['*'], 'technical');
        $commercial = tenderFile::where('tender_id','=',$id)->where('type', '=','Commercial')->paginate(5, ['*'], 'commercial');
        $documents = tenderFile::where('tender_id','=',$id)->where('type', '=','Tender Documents')->paginate(5, ['*'], 'documents');
        return view('prevtender', compact('tender','technical', 'commercial', 'documents'));
    }

    public function download(String $files){
        $file= 'storage/'.$files;
        return response()->download($file);
    }

    public function DeleteTender(String $id){
        $tender = tender::find($id);
        $files = tenderFile::where('tender_id','=',$id)->get();
        $filestoDelete = tenderFile::where('tender_id','=',$id);
        if(!$tender){
            return back()->with('errors','Could not be deleted!');
        }

        foreach ($files as $file) {
            if (Storage::disk('public')->exists($file->name)) {
                Storage::disk('public')->delete($file->name);
            } else {

            }
        }
        $filestoDelete->delete();
        $tender->delete();
        return back();
    }
    public function Search(Request $request){
        $output="";
        $i=0;
        $tender = tender::where('Name','Like','%'.$request->search.'%')->orWhere('Number','Like','%'.$request->search.'%')->orWhere('client','Like','%'.$request->search.'%')->orWhere('Consultant','Like','%'.$request->search.'%')
        ->orWhere('contractor','Like','%'.$request->search.'%')->get();

        foreach($tender as $tender){
            $output.=
            '<tr>
                <td><b>'.++$i.'</b></td>
                <td>'.$tender->Name.'</td>
                <td>'.$tender->Number.'</td>
                <td>'.$tender->value.'</td>
                <td>'.$tender->status.'</td>
                <td>'.$tender->contractor.'</td>
                <td>'.$tender->client.'</td>
                <td>'.$tender->Consultant.'</td>
                <td><a class="btn btn-primary" href="/preview/'.$tender->id.'">View</a></td>
                <td><a class="btn btn-success" href="/edit/'.$tender->id.'">Edit</a></td>
                <td><a class="btn btn-danger" onclick="return confirm("are you sure?")" href="/deleteTender/'.$tender->id.'">Delete</a></td>
            </tr>';
        }

        return response($output);

    }
}





 