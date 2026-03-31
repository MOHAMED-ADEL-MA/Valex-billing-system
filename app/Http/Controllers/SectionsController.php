<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=Sections::all();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'section_name'=>'required|unique:sections'
        ],[
            'section_name.required'=>'يرجي ادخال اسم القسم',
            'section_name.unique'=>'اسم القسم مسجل مسبقا'
        ]);
        

            Sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name)
            ]);
            session()->flash('Add','تمت اضافه القسم بنجاح');
            return redirect('/sections');
        

    }

    /**
     * Display the specified resource.
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id=$request->id;

        $this->validate($request,[
            'section_name'=>'required|unique:sections,section_name,'.$id
        ],[
            'section_name.required'=>'يرجي ادخال اسم القسم',
            'section_name.unique'=>'اسم القسم مسجل مسبقا'
            
        ]);
        
            $sections=Sections::find($id);

            $sections->update([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                
            ]);
            session()->flash('Add','تم تعديل القسم بنجاح');
            return redirect('/sections');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Sections::where('id',$request->id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
