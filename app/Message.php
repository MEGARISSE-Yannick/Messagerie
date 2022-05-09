<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'content', 'from_id', 'to_id', 'read_at', 'created_at','statut','commentaire'
    ];

    protected $dates  = ['created_at', 'read_at'];
    public $timestamps = false;


    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
