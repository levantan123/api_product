<?php
namespace App\Http\Controllers;
 use App\Services\OrderService;
 use Illuminate\Http\Request;

 class OrderController extends Controller{
     protected $orderService;
     public function __construct(OrderService $orderService)
     {
         $this->orderService = $orderService;
     }
     public function create(Request $request){
         $this->validate($request,[
             'product_id'=>'required|exists:Products,_id',
             'amount'=>'required|numeric|gt:0',
             'user_id'=>'required|exists:Users,_id'
         ],[
             'exists'=>':attribute không tồn tại trong bảng',
             'required'=>':attribute không được để trống',
             'gt'=>'Số lượng phải lớn hơn 0'
         ]);
         $create = $this->orderService->create($request);
         return response()->json($create->toArray());
     }
     public function listOrder(Request $request){
         $this->validate($request,[
             'order_id'=>'exists:Orders,_id'
         ],[
             'exists'=>':attribute không tồn tại trong bảng',
         ]);
         $listOrder = $this->orderService->getOrder($request);
         return response()->json($listOrder->toArray());
     }
     public function update(Request $request){
         $this->validate($request,[
             'order_id'=>'exists:Orders,_id',
             'user_id'=>'exists:Users,_id',
             'amount'=>'gt:0'
         ],[
             'exists'=>':attribute không tồn tại trong bảng',
             'gt'=>'Số lượng phải lớn hơn 0'
         ]);
         $update = $this->orderService->update($request);
         return response()->json($update->toArray());
     }
     public function delete(Request $request){
        $this->validate($request,[
            'order_id'=>'exists:Orders,_id',
            'user_id'=>'exists:Users,_id',
        ],[
            'exists'=>':attribute không tồn tại trong bảng',
        ]);
        $delete = $this->orderService->delete($request);
        return response()->json($delete->toArray());
     }
 }