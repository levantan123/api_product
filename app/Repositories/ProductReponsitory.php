<?php
namespace App\Repositories;

use App\Models\Product;
use Jenssegers\Mongodb\Eloquent\Model;

class ProductReponsitory extends BaseRepository{
    public function __construct(Product $model)
    {
       $this->model =  $model;
    }
    public function getProduct($categories_id=null,$product_id=null){
        return $this->model->getProduct($categories_id,$product_id);
    }
}