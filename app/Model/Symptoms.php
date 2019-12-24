<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Symptoms extends Model
{
    use Notifiable;

    protected $table = "symptoms";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('symptoms')->insert($data);
    }

    public function getByName($name) {
        return DB::table('symptoms')->where('name', $name)->first();
    }

    public function getById($id) {
        return DB::table('symptoms')->where('id', $id)->first();
    }


    public function get() {
        return DB::table('symptoms')->get();
    }

    public function deleteById($id) {
        return DB::table('symptoms')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('symptoms')->where('id', $id)->update(['name'=>$data['name']]);
    }

    public function addSym($data)
    {
        return DB::table('disease_symptom')->insert($data);
    }
}
