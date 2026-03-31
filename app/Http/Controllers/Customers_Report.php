<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;

class Customers_Report extends Controller
{
    public function index(){
        $sections= Sections::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function search(Request $request){
        $request->validate(['Section'=>'required'],['Section.required'=>'يرجي اختيار القسم']);

        if($request->Section && $request->product && $request->start_at=='' && $request->end_at==''){
            $details=Invoices::where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections= Sections::all();
            return view('reports.customers_report',compact('details','sections'));
        }

        else{

            $start_at=date($request->start_at);
            $end_at=date($request->end_at);

            $details=Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections= Sections::all();
            return view('reports.customers_report',compact('details','sections','start_at','end_at'));
        }
    }
}
