<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Users extends Model
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    public function insert($data)
    {
        return DB::table('users')->insert($data);
    }

    public function getByName($name) {
        return DB::table('users')->where('name', $name)->first();
    }

    public function getById($id) {
        return DB::table('users')->where('id', $id)->first();
    }

    public function get() {
        return DB::table('users')->get();
    }

    public function deleteById($id) {
        return DB::table('users')->where('id', $id)->delete();
    }

}
