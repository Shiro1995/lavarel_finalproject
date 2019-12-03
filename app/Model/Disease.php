<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Disease extends Model
{
    use Notifiable;

    public function insert($data) {
        return DB::table('disease')->insert($data);
    }

    public function getByName($name) {
        return DB::table('disease')->where('name', $name)->first();
    }

    public function getById($id) {
        return DB::table('disease')->where('id', $id)->first();
    }

    public function get() {
        return DB::table('disease')->get();
    }

    public function deleteById($id) {
        return DB::table('disease')->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        return DB::table('disease')->where('id', $id)->update(['name'=>$data['name']]);
    }

    public function synchWithServerFromLocal($disease) {
        $this->insert($disease);
    }
}
