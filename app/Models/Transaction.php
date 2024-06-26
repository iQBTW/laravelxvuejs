<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id', 'status', 'date_start', 'date_end', 'status'];

    // protected $casts = [
    //     'status' => 'boolean'
    // ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function transactiondetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

}
