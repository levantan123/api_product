<?php
namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function create(Request $request){
        $this->validate($request,[
           'title'=>'required|unique:Products',
           'categories_id'=>'required|exists:Categories,_id',
           'amount'=>'required|numeric|gte:0'
        ],[
            'required'=>':attribute không được để trống',
            'unique'=>':attribute đã tồn tại',
            'exists'=>':attribute không tồn tại trong bảng',
            'numeric'=>':attribute phải là số',
            'gte'=>':attribute phải lớn hơn hoặc bằng 0'
        ]);
        $create = $this->productService->create($request);
        return  response()->json($create->toArray());
    }
    public function listProduct(Request $request){
        $this->validate($request,[
            'categories_id'=>'exists:Categories,_id',
            'product_id'=>'exists:Products,_id'
        ],[
            'exists'=>':attribute không tồn tại'
        ]);
        $getPost = $this->productService->listProduct($request);
        return response()->json($getPost->toArray());
    }
}