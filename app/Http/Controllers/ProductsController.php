<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=Sections::all();
        $products=Products::all();
        return view('products.products',compact('sections','products'));
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
            'product_name'=>'required',
            'section_id'=>'required'
        ],[
            'product_name.required'=>'يرجي ادخال اسم المنتج',
            'section_id.required'=>'يرجي اختيار القسم'
        ]);

        Products::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id
        ]);
        session()->flash('Add','تمت اضافه المنتج بنجاح');
        return redirect('/products');

    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'product_name'=>'required:Products'
        ],[
            'product_name.required'=>'يرجي ادخال اسم المنتج'
            
        ]);

        $id=Sections::where('section_name',$request->section_name)->first()->id;
        $product=Products::find($request->pro_id);
        $product->update([
            'product_name'=>$request->Product_name,
            'description'=>$request->description,
            'section_id'=>$id
        ]);
        session()->flash('Add', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product=Products::find($request->pro_id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
