<?php

namespace App\Services;

use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Http\Responses\StatusCode;
use App\Repositories\OrderRepository;
use App\Repositories\ProductReponsitory;
use MongoDB\BSON\ObjectId;

class OrderService
{
    protected $orderRepository;
    protected $productReponsitory;

    public function __construct(OrderRepository $orderRepository, ProductReponsitory $productReponsitory)
    {
        $this->orderRepository = $orderRepository;
        $this->productReponsitory = $productReponsitory;
    }

    public function create($request)
    {
        $product = $this->productReponsitory->findById(new ObjectId($request->get('product_id')));
        $amount = $product->amount;
        if ((int)$request->get('amount') > $amount) return (new ResponseError(StatusCode::BAD_REQUEST, 'Amount không hợp lệ!'));
        $create = $this->orderRepository->create([
            'product_id' => new ObjectId($request->get('product_id')),
            'amount' => (int)$request->get('amount'),
            'user_id' => new ObjectId($request->get('user_id'))
        ]);
        $product->decrement('amount', $request->get('amount'));
        return (new ResponseSuccess($create, 'Tạo đơn hàng thành công'));
    }

    public function update($request)
    {
        $find = $this->orderRepository->find(['_id' => new ObjectId($request->get('order_id')), 'user_id' => new ObjectId($request->get('user_id'))])->first();
        if ((is_null($find))) return (new ResponseError(StatusCode::BAD_REQUEST, 'order_id hoặc user_id không hợp lệ!'));
        $product = $this->productReponsitory->findById($find->product_id);
        $amount = $product->amount;
        if ((int)$request->get('amount') > $find->amount + $amount) return (new ResponseError(StatusCode::BAD_REQUEST, 'amount hông hợp lệ!'));
        $product->increment('amount', -((int)$request->get('amount') - $find->amount));
        $update = $find->update([
            'amount' => (int)$request->get('amount'),
        ]);
        return (new ResponseSuccess($update, 'Update thành công'));
    }

    public function getOrder($request)
    {
        $array = [];
        $getOrder = $this->orderRepository->getOrder($request->get('order_id'));
        foreach ($getOrder as $value) {
            $getOne = ['order_id' => $value->_id, 'username' => $value->user['full_name'], 'product' => $value->product['title'], 'user_id' => (string)$value->user_id, 'product_id' => (string)$value->product_id];
            array_push($array, $getOne);
        }
        return (new ResponseSuccess(['orders' => $array], 'Lấy bản ghi thành công!'));
    }

    public function delete($request)
    {
        $find = $this->orderRepository->find(['_id' => new ObjectId($request->get('order_id')), 'user_id' => new ObjectId($request->get('user_id'))])->first();
        $product = $this->productReponsitory->findById(new ObjectId($find->product_id));
        if (is_null($find)) return (new ResponseError(StatusCode::BAD_REQUEST, 'order_id hoặc user_id không phù hợp! Xóa thất bại'));
        $tamp = $find->amount;
        $find->delete();
        $product->increment('amount', $tamp);
        return (new ResponseSuccess($find, 'Xóa bản ghi thành công'));
    }
}