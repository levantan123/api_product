<?php
namespace App\Repositories;

use App\Models\Order;
use Jenssegers\Mongodb\Eloquent\Model;

class OrderRepository extends BaseRepository{
    public function __construct(Order $model)
    {
//        parent::__construct($model);
        $this->model = $model;
    }
    public function getOrder($order_id=null){
        return $this->model->getOrder($order_id);
    }
}