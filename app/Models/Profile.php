<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'last_name', 'birthday', 'gender',
        'address', 'city', 'country',
    ];

    // Inverse One-to-One
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
