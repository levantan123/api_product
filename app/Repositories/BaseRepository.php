<?php


namespace App\Repositories;


use Jenssegers\Mongodb\Eloquent\Model;

class BaseRepository
{
    public $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data){
        return $this->model::create($data);
    }
    public function all(){
        return $this->model::all();
    }
    public function find($data){
        return $this->model::where($data);
    }
    public function where($id,$value){
        return $this->model::where($id,$value);
    }
    public function findById($id){
        return $this->model::find($id);
    }
}
