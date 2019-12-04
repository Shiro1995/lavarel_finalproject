<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Prognostic extends Model
{
    use Notifiable;

    public function insert($data) {
        return DB::table('prognostics')->insert($data);
    }
}
