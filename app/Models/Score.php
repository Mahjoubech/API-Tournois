<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = [
        'player1_id',
        'player2_id',
        'match_id',
        'player1_score',
        'player2_score',
        'user_id' 
    ];    public function match()
    {
        return $this->belongsTo(Matches::class);
    }
    public function playerOne()
    {
        return $this->belongsTo(Players::class,'player1_id');
    }
    public function playerTwo()
    {
        return $this->belongsTo(Players::class,'player2_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
