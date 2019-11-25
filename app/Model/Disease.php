<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

// https://reference.yourdictionary.com/books-literature/different-types-of-books.html
class Disease extends Model
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

    public function getSymptons($id)
    {
        $data = DB::table('disease_symptom')->where('disease_id',$id);
        $idSymptom = array();
        if($data->count() > 0) {
            foreach ($data->get() as $item) {
                array_push($idSymptom, $item->symptom_id);
            }
            return DB::table('symptoms')->whereIn('id',$idSymptom)->get();
        }
    }
    public function addsymptoms()
    {
            DB::table('disease_symptom')->insert(58);
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptoms::class);
    }


}
