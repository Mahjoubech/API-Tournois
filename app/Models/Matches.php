<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;
    public $fillable = ['date_match','tournois_id','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tournois()
    {
        return $this->belongsTo(Tournois::class);
    }
    public function players()
{
    return $this->belongsToMany(Players::class, 'match_player', 'match_id', 'player_id');
}

    

}
