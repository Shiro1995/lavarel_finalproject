<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Pharmacy extends Model
{
    use Notifiable;

    protected $table = "pharmacy";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('pharmacy')->insert($data);
    }

    public function get() {
        return DB::table('pharmacy')->get();
    }

    public function getByName($name) {
        return DB::table('pharmacy')->where('name', $name)->first();
    }
    public function deleteById($id){
        return DB::table('pharmacy')->where('id',$id)->delete();
    }
    public function getById($id) {
        return DB::table('pharmacy')->where('id', $id)->first();
    }

    public function updateById($id, $data)
    {
        return DB::table('pharmacy')->where('id', $id)->update(['name'=>$data['name']]);
    }

}
