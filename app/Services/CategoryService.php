<?php
namespace App\Services;
use App\Http\Responses\ResponseSuccess;
use App\Repositories\CategoryRepository;

class CategoryService{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository= $categoryRepository;
    }
    public function create($request){
        $create = $this->categoryRepository->create([
            'name'=>$request->get('name'),
            'parent_id'=>$request->get('parent_id'),
        ]);
        return (new ResponseSuccess($create,'Tạo danh mục sản phảm thành công!'));
    }
}