<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceArchive extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=Invoices::onlyTrashed()->get();
        return view('invoices.Archive_Invoices',compact('invoices'));
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
    public function show( $id)
    {
        $invoices=Invoices::withTrashed()->where('id',$id)->first();
        $details=Invoices_details::where('id_Invoice',$id)->get();
        $attachments=invoice_attachments::where('invoice_id',$id)->get();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Invoices::withTrashed()->where('id',$request->invoice_id)->restore();
        session()->flash('restore');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice=Invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $details=invoice_attachments::where('invoice_id',$request->invoice_id)->first();
            
            if(!empty($details->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }

            $invoice->forceDelete();
            session()->flash('delete');
            return redirect('/archive');
    }
}
