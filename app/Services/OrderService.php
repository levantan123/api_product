<?php
namespace App\Services;

use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Http\Responses\StatusCode;
use App\Repositories\OrderRepository;
use App\Repositories\ProductReponsitory;
use MongoDB\BSON\ObjectId;

class OrderService{
    protected $orderRepository;
    protected $productReponsitory;
    public function __construct(OrderRepository $orderRepository, ProductReponsitory $productReponsitory)
    {
        $this->orderRepository = $orderRepository;
        $this->productReponsitory = $productReponsitory;
    }
    public function create($request){
        $product = $this->productReponsitory->findById(new ObjectId($request->get('product_id')));
        $amount = $product->amount;
        if ((int)$request->get('amount') > $amount)  return (new ResponseError(StatusCode::BAD_REQUEST,'Amount không hợp lệ!'));
        $create = $this->orderRepository->create([
            'product_id'=>new ObjectId($request->get('product_id')),
            'amount'=>(int)$request->get('amount'),
            'user_id'=>new ObjectId($request->get('user_id'))
        ]);
        return (new ResponseSuccess($create,'Tạo đơn hàng thành công'));
    }
    public function getOrder($request){
        $array=[];
        $getOrder = $this->orderRepository->getOrder($request->get('order_id'));
        foreach ($getOrder as $value){
            $getOne = ['Order_id'=>$value->_id,'Người mua'=>$value->user['full_name'],'Sản phẩm'=>$value->product['title'],'user_id'=>(string)$value->user_id,'product_id'=>(string)$value->product_id];
            array_push($array,$getOne);
        }
        return (new ResponseSuccess(['orders'=>$array],'Lấy bản ghi thành công!'));
    }
}