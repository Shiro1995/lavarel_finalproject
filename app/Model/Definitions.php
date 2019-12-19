<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Definitions extends Model
{
    use Notifiable;

    protected $table = "definitions";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('definitions')->insert($data);
    }

    public function getByName($name) {
        return DB::table('definitions')->where('name', $name)->first();
    }
    public function getById($id) {
        return DB::table('definitions')->where('id', $id)->first();
    }


    public function get() {
        return DB::table('definitions')->get();
    }
    public function deleteById($id) {
        return DB::table('definitions')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('definitions')->where('id', $id)->update(['name'=>$data['name']]);
    }
    public function addSym($data)
    {
        return DB::table('disease_symptom')->insert($data);
    }
}
