<?php
namespace App\Services;
use App\Http\Responses\ResponseSuccess;
use App\Repositories\CategoryRepository;
use MongoDB\BSON\ObjectId;

class CategoryService{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository= $categoryRepository;
    }
    public function create($request){
        $data=[
          'name'=> $request->get('name')
        ];
        if(!is_null($request->get('parent_id')) && ($request->get('parent_id'))!=""){
            $data['parent_id'] = new ObjectId($request->get('parent_id'));
        }
        $create = $this->categoryRepository->create($data);
        return (new ResponseSuccess($create,'Tạo danh mục sản phảm thành công!'));
    }
}