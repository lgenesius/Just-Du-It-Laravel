<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function transactions(){
        return $this->belongsToMany(Transaction::class, 'detail_transactions');
    }
}
