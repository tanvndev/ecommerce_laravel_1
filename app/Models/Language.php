<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Language extends Model
{

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'canonical',
        'image',
        'publish',
        'user_id',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
