<?php
namespace App\Services;
use App\Http\Responses\ResponseSuccess;
use App\Repositories\ProductReponsitory;
use MongoDB\BSON\ObjectId;

class ProductService{
    protected $productReponsitory;
    public function __construct(ProductReponsitory $productReponsitory)
    {
        $this->productReponsitory = $productReponsitory;
    }
    public function create($request){
        $create = $this->productReponsitory->create([
            'title'=>$request->get('title'),
            'categories_id'=>new ObjectId($request->get('categories_id')),
            'amount'=>(int)$request->get('amount'),
        ]);
        return (new ResponseSuccess($create,'Tạo sản phẩm thành công!'));
    }
    public function listProduct($request){
        $array=[];
        $getList = $this->productReponsitory->getProduct($request->get('categories_id'),$request->get('product_id'));
        foreach($getList as $value){
            $getOne = ['product_name'=>$value->title,'product_id'=>$value->_id,'categories_id'=>(string)$value->product['_id'],
                'categories_name'=>$value->product['name']];
            array_push($array,$getOne);
        }
        return (new ResponseSuccess(['product'=>$array],'Lay ban ghi thanh cong'));
    }
}