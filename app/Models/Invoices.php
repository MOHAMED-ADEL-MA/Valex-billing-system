<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[

        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_comission',
        'Discount',
        'Value_vat',
        'Rate_vat',
        'Total',
        'status',
        'value_status',
        'note',
        'Payment_date'
        
    ];

    public function section(){
        return $this->belongsTo(Sections::class);
    }
}
