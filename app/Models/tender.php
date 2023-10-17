<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tender extends Model
{
    use HasFactory;
    protected $fillable=[
        "Name",
        "Number",
        "ScopeofWork",
        "status",
        "client",
        "Consultant",
        "value",
        "contractor",
    ];

    public function tenderFile(){
        return $this->hasMany(tenderFile::class, "tender_id");
    }
}
