<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Prognostics extends Model
{
    use Notifiable;

    protected $table = "prognostics";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('prognostics')->insert($data);
    }

    public function getByName($name) {
        return DB::table('prognostics')->where('name', $name)->first();
    }
    public function getById($id) {
        return DB::table('prognostics')->where('id', $id)->first();
    }


    public function get() {
        return DB::table('prognostics')->get();
    }
    public function deleteById($id) {
        return DB::table('prognostics')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('prognostics')->where('id', $id)->update(['name'=>$data['name']]);
    }
    public function addSym($data)
    {
        return DB::table('disease_symptom')->insert($data);
    }
}
