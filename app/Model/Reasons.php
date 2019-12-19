<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Reasons extends Model
{
    use Notifiable;

    protected $table = "reasons";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('reasons')->insert($data);
    }

    public function getByName($name) {
        return DB::table('reasons')->where('name', $name)->first();
    }
    public function getById($id) {
        return DB::table('reasons')->where('id', $id)->first();
    }


    public function get() {
        return DB::table('reasons')->get();
    }
    public function deleteById($id) {
        return DB::table('definitions')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('reasons')->where('id', $id)->update(['name'=>$data['name']]);
    }
//    public function addSym($data)
//    {
//        return DB::table('disease_symptom')->insert($data);
//    }
}
