<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderServiceInterface
     */
    protected $orderService;

    /**
     * OrderController constructor.
     *
     * @param OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('admin.orders', ['orders' => $orders]);
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        
        if (!$order) {
            abort(404);
        }
        
        return view('admin.order-show', ['order' => $order]);
    }

    /**
     * Update the specified order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:2',
        ]);

        $this->orderService->updateOrderStatus($id, $request->status);

        return back()->with('success', 'Order status successfully updated');
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->orderService->deleteOrder($id);
        
        return redirect()->route('admin.orders')->with('success', 'Order successfully deleted');
    }
}
