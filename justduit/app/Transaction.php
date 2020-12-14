<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'header_transactions';
    protected $fillable =['user_id', 'total'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shoes(){
        return $this->belongsToMany(Shoe::class, 'detail_transactions')
        ->withTimestamps()->withPivot('quantity');
    }
}
