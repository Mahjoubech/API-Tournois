<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Players;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tournois extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'user_id',
       ];
    public function user(){
        return $this->BelongsTo(User::class);
    }
    public function players(){
        return $this->hasMany(Players::class);
    }
}
