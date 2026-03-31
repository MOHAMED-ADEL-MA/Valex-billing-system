<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\League\Flysystem\FilesystemOperator;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;


class InvoicesDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        $details=Invoices_details::where('id_Invoice',$id)->get();
        $attachments=invoice_attachments::where('invoice_id',$id)->get();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        invoice_attachments::where('id',$request->id_file)->delete();
        //$path=public_path('Attachments/'.$request->invoice_number.'/'.$request->file_name);
        //Storage::delete('$path');
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete','تم حذف المرفق بنجاح');
        return back();
    }

    public function open_file($invoice_number,$file_name){

    
        $path = public_path('Attachments/'.$invoice_number.'/'.$file_name);

    
        return response()->file($path);
    }

    public function download($invoice_number,$file_name){

    
        $path = public_path('Attachments/'.$invoice_number.'/'.$file_name);

    
        return response()->download( $path);
    }

    
}
