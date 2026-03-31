<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\Invoices;
use App\Models\Invoices_details;
use App\Models\Sections;
use App\Models\User;
use App\Notifications\Add_invoice_new;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=Invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections=Sections::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Invoices::create([

            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_comission'=>$request->Amount_Commission,
            'Discount'=>$request->Discount,
            'Value_vat'=>$request->Value_VAT,
            'Rate_vat'=>$request->Rate_VAT,
            'Total'=>$request->Total,
            'status'=>'غير مدفوعه',
            'value_status'=>2,
            'note'=>$request->note,

        ]);

        $invoice_id=Invoices::latest()->first()->id;

        Invoices_details::create([

            'id_Invoice'=>$invoice_id,
            'invoic_number'=>$request->invoice_number,
            'product'=>$request->product,
            'section'=>$request->Section,
            'status'=>'غير مدفوعه',
            'value_status'=>2,
            'note'=>$request->note,
            'user'=>(Auth::user()->name)

        ]);

        if ($request->hasFile('pic')) {

            $this->validate($request,[
                'pic'=>'mimes:png,jpg,jpeg,pdf'
            ],[
                'pic.mimes'=>'خطأ يجب ان تكون صيغه الملف jpg,png,jpeg,pdf'
            ]);
    

            $invoice_id=Invoices::latest()->first()->id;
            $image=$request->file('pic');
            $file_name=$image->getClientOriginalName();
            $invoice_number=$request->invoice_number;

            // $attachments= new invoice_attachments();
            // $attachments->file_name=$file_name;
            // $attachments->invoice_number=$invoice_number;
            // $attachments->invoice_id=$invoice_id;
            // $attachments->Created_by=(Auth::user()->name);


            invoice_attachments::create([
                'file_name'=>$file_name,
                'invoice_number'=>$invoice_number,
                'invoice_id'=>$invoice_id,
                'Created_by'=>(Auth::user()->name)

            ]);

            $request->pic->move(public_path('Attachments/'.$invoice_number),$file_name);
            

        }

        $user=User::get();
        Notification::send($user,new Add_invoice_new($invoice_id));
        //$user->notify(new AddInvoice($invoice_id));
        

        session()->flash('Add','تمت اضافه الفاتوره بنجاح');
            return back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        $sections=Sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Invoices::where('id',$request->id)->update([
            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_comission'=>$request->Amount_Commission,
            'Discount'=>$request->Discount,
            'Value_vat'=>$request->Value_VAT,
            'Rate_vat'=>$request->Rate_VAT,
            'Total'=>$request->Total,
            'status'=>'غير مدفوعه',
            'value_status'=>2,
            'note'=>$request->note,
        ]);
        session()->flash('Add','تم تعديل الفاتورة');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoice=Invoices::where('id',$request->invoice_id)->first();
        $id=$request->id_page;

        
        
        
        if($id==2){
            // If you use soft delete use onely this request: 

            $invoice->delete();

            session()->flash('Archive');
            return redirect('/invoices');
        }

        else{
            // If you use force delete use this request: 
            $details=invoice_attachments::where('invoice_id',$request->invoice_id)->first();
            
            if(!empty($details->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }

            $invoice->forceDelete();
            session()->flash('delete');
            return redirect('/invoices');

        }


    }


    public function getproducts($id){

        $products=DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }


    public function Status_Update($id, Request $request){

        
        $invoice=Invoices::find($id);
        
        if($request->Status === 'مدفوعة'){

            $invoice->update([
                'status'=>$request->Status,
                'value_status'=>1,
                'Payment_date'=>$request->Payment_Date,
            ]);

            Invoices_details::create([
                'id_Invoice'=>$request->invoice_id,
                'invoic_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->Section,
                'status'=>'مدفوعه',
                'value_status'=>1,
                'note'=>$request->note,
                'Payment_date'=>$request->Payment_Date,
                'user'=>(Auth::user()->name)
            ]);
        }

        else{

            $invoice->update([
                'status'=>$request->Status,
                'value_status'=>3,
                'Payment_date'=>$request->Payment_Date,
            ]);

            Invoices_details::create([
                'id_Invoice'=>$request->invoice_id,
                'invoic_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->Section,
                'status'=>'مدفوعه جزئيا',
                'value_status'=>3,
                'note'=>$request->note,
                'Payment_date'=>$request->Payment_Date,
                'user'=>(Auth::user()->name)
            ]);
        }
        session()->flash('update');
        return redirect('/invoices');
    }


    public function invoices_paid(){
        $invoices=Invoices::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function invoices_unpaid(){
        $invoices=Invoices::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function invoices_Partial(){
        $invoices=Invoices::where('value_status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }

    public function Print_invoice($id){
        $invoices=Invoices::where('id',$id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }

    public function markasRead_all(){
        $unreadNotification=auth()->user()->unreadNotifications;

        if($unreadNotification){
            $unreadNotification->markAsRead();
            return back();
        }
    }
}
