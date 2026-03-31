<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'file_name'=>'mimes:png,jpg,jpeg,pdf'
        ],[
            'file_name.mimes'=>'خطأ يجب ان تكون صيغه الملف jpg,png,jpeg,pdf'
        ]);

        $image=$request->file('file_name');
        $file_name=$image->getClientOriginalName();

        invoice_attachments::create([
            'invoice_id'=>$request->invoice_id,
            'invoice_number'=>$request->invoice_number,
            'file_name'=>$file_name,
            'Created_by'=>(Auth::user()->name)
        ]);
        $request->file_name->move(public_path('Attachments/'.$request->invoice_number),$file_name);
        session()->flash('Add','تم اضافه المرفق بنجاح');
            return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
}
