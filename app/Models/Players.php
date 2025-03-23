<?php

namespace App\Models;
use App\Models\Tournois;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;
protected $fillable = ['name', 'number','user_id','tournois_id'];
    public function tournois()
    {
        return $this->belongsTo(Tournois::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
