<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tenderFile extends Model
{
    use HasFactory;

    protected $fillable =[
        "name",
        "type",
        "tender_id",
    ];

    public function Tender(){
        return $this->belongsTo(tender::class);
    }
}
