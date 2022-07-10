<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cast extends Model
{
    protected $table="cast";
    protected $guarded=[];

    public function box(){
        return $this->belongsTo(Box::class,"box_id");
    }

}
