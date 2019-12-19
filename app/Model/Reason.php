<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Reason extends Model
{
    use Notifiable;

    public function insert($data) {
        return DB::table('reasons')->insert($data);
    }
}
