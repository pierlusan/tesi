<?php

namespace App\Models;

use App\Enum\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'status',
        'type',
        'client_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => EventStatus::class,
    ];

    public function client(){
        return $this->belongsTo(User::class, 'client_id');
    }

}
