<?php
namespace App\Http\Controllers;
 use App\Services\CategoryService;
 use Illuminate\Http\Request;

 class CategoryController extends Controller{
     protected $categoryService;
     public function __construct(CategoryService $categoryService)
     {
         $this->categoryService = $categoryService;
     }
     public function create(Request $request){
         $this->validate($request,[
             'name'=>'required|unique:Categories',
             'parent_id'=>'nullable|exists:Categories,_id'
         ],[
             'required'=>':attribute không được để trống',
             'unique'=>':attribute đã tồn tại',
             'exists'=>':attribute không tồn tại'
         ]);
         $create = $this->categoryService->create($request);
         return response()->json($create->toArray());
     }
 }