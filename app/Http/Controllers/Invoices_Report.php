<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class Invoices_Report extends Controller
{
    public function index(){
        return view('reports.invoices_report');
    }


    public function search(Request $request){
        
        if($request->rdio == '1'){
            $request->validate(['type'=>'required']);

            // without Date
            if($request->type && $request->start_at=='' && $request->end_at==''){
                $details=Invoices::where('status',$request->type)->get();
                $type=$request->type;

                return view('reports.invoices_report',compact('details','type'));
            }
            else{   
                // with Date
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                $type=$request->type;

                $details=Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('status',$request->type)->get();
                return view('reports.invoices_report',compact('details','type','start_at','end_at'));

            }
        }
        else{
            //with invoice number
            $request->validate(['invoice_number'=>'required']);

            $details=Invoices::where('invoice_number',$request->invoice_number)->get();
            $type=$request->type;

            return view('reports.invoices_report',compact('details','type'));
        }


    }
}
