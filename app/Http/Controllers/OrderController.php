<?php
/**
 * File name: OrderController.php
 * Last modified: 2020.05.05 at 16:55:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers;

use App\Criteria\Orders\NotPaidOrderCriteria;
use App\Criteria\Orders\OrdersOfUserCriteria;
use App\Criteria\Users\ClientsCriteria;
use App\Criteria\Users\DriversCriteria;
use App\Criteria\Users\DriversOfMarketCriteria;
use App\Criteria\Users\ManagersCriteria;
use App\DataTables\OrderDataTable;
use App\DataTables\PaymentOrderDataTable;
use App\DataTables\ProductOrderDataTable;
use App\Events\OrderChangedEvent;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderLocationsStatus;
use App\Notifications\AssignedOrder;
use App\Notifications\StatusChangedOrder;
use App\Repositories\CustomFieldRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderLocationsStatusRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\TruckRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class OrderController extends Controller
{
    /** @var  OrderRepository */
    private $orderRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderStatusRepository
     */
    private $orderStatusRepository;
    /**
     * @var OrderLocationsStatusRepository
     */
    private $orderLocationsStatusRepository;
    /** @var  NotificationRepository */
    private $notificationRepository;
    /** @var  PaymentRepository */
    private $paymentRepository;
    /**
     * @var TruckRepository
     */
    private $TruckRepository;

    public function __construct(OrderRepository $orderRepo, CustomFieldRepository $customFieldRepo, UserRepository $userRepo
        , OrderStatusRepository $orderStatusRepo,OrderLocationsStatusRepository $orderLocationsStatusRepo, NotificationRepository $notificationRepo, PaymentRepository $paymentRepo, TruckRepository $truckRepo)
    {
        parent::__construct();
        $this->orderRepository = $orderRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->userRepository = $userRepo;
        $this->orderStatusRepository = $orderStatusRepo;
        $this->orderLocationsStatusRepository = $orderLocationsStatusRepo;
        $this->notificationRepository = $notificationRepo;
        $this->paymentRepository = $paymentRepo;
        $this->TruckRepository = $truckRepo;
    }

    /**
     * Display a listing of the Order.
     *
     * @param OrderDataTable $orderDataTable
     * @return Response
     */
    public function index(OrderDataTable $orderDataTable)
    {
        return $orderDataTable->render('orders.index');
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {
        $user = $this->userRepository->getByCriteria(new ClientsCriteria())->pluck('name', 'id');
        //$driver = $this->userRepository->getByCriteria(new DriversCriteria())->pluck('name', 'id');
        $driver = [];
        $orderStatus = $this->orderStatusRepository->pluck('status', 'id');
        $manager = [];
        $ordersSelected =[];
        $orderLocationsStatus = $this->orderLocationsStatusRepository->pluck('locations_status', 'id');
        $orderTypeofTruck = $this->TruckRepository->pluck('type_truck', 'id');

        $hasCustomField = in_array($this->orderRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->orderRepository->model());
            $html = generateCustomField($customFields);
        }
        if (auth()->user()->hasRole('admin')){
            $notpaid = $this->paymentRepository->getByCriteria(new NotPaidOrderCriteria())->pluck('name', 'id');
            return view('orders.create')->with("manager", $manager)->with("ordersSelected", $ordersSelected)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("driver", $driver)->with("orderStatus", $orderStatus)->with("orderLocationsStatus", $orderLocationsStatus)->with("orderLocationsStatus", $orderLocationsStatus)->with("notpaid", $notpaid)->with("orderTypeofTruck", $orderTypeofTruck);

        }
        return view('orders.create')->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("driver", $driver)->with("orderStatus", $orderStatus)->with("orderLocationsStatus", $orderLocationsStatus)->with("orderTypeofTruck", $orderTypeofTruck);

    }

    /**
     * Store a newly created Order in storage.
     *
     * @param CreateOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->except(['partner[]']);
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->orderRepository->model());
        try {
            $order = $this->orderRepository->create($input);
            $order->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.order')]));

        return redirect(route('orders.index'));
    }

    /**
     * Display the specified Order.
     *
     * @param int $id
     * @param ProductOrderDataTable $productOrderDataTable
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */

    public function show(PaymentOrderDataTable $paymentOrderDataTable, $id)
    {
        $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
        $order = $this->orderRepository->findWithoutFail($id);
        $manager = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        $ordersSelected = $order->partnerapply()->pluck('users.id')->toArray();
        if (empty($order)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.order')]));

            return redirect(route('orders.index'));
        }
        $subtotal = 0;
        if(isset($order->payment)){
            $subtotal += $order->payment->price;
        }
        $total = $subtotal + $order['delivery_fee'];
        $taxAmount = $total * $order['tax'] / 100;
        $total += $taxAmount;
        $paymentOrderDataTable->id = $id;

        return $paymentOrderDataTable->render('orders.show', ["order" => $order, "total" => $total, "subtotal" => $subtotal,"taxAmount" => $taxAmount,"manager" => $manager,"ordersSelected" => $ordersSelected]);
    }

    /**
     * Show the form for editing the specified Order.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
        $order = $this->orderRepository->findWithoutFail($id);
        $count=DB::table('partner_apply_orders')->where('user_id',auth()->id())->where('order_id',$id)->count();
        $manager = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        $ordersSelected = $order->partnerapply()->pluck('users.id')->toArray();
        if (empty($order)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.order')]));

            return redirect(route('orders.index'));
        }

        $market = $order->productOrders()->first();
        $market = isset($market) ? $market->product['market_id'] : 0;

        $user = $this->userRepository->getByCriteria(new ClientsCriteria())->pluck('name', 'id');
        $driver = $this->userRepository->getByCriteria(new DriversOfMarketCriteria($market))->pluck('name', 'id');
        $orderStatus = $this->orderStatusRepository->pluck('status', 'id');
        $orderLocationsStatus = $this->orderLocationsStatusRepository->pluck('locations_status', 'id');
        $orderTypeofTruck = $this->TruckRepository->pluck('type_truck', 'id');
        $customFieldsValues = $order->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->orderRepository->model());
        $hasCustomField = in_array($this->orderRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        if (auth()->user()->hasRole('admin')){
            $notpaid = $this->paymentRepository->getByCriteria(new NotPaidOrderCriteria())->pluck('description', 'id');
            return view('orders.edit')->with('order', $order)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("driver", $driver)->with("orderStatus", $orderStatus)->with("orderLocationsStatus", $orderLocationsStatus)->with("notpaid", $notpaid)->with("manager", $manager)->with("ordersSelected", $ordersSelected)->with("orderTypeofTruck", $orderTypeofTruck);
        }
        return view('orders.edit')->with('count', $count)->with('order', $order)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("driver", $driver)->with("orderStatus", $orderStatus)->with("orderLocationsStatus", $orderLocationsStatus)->with("orderTypeofTruck", $orderTypeofTruck);

    }

    /**
     * Update the specified Order in storage.
     *
     * @param int $id
     * @param UpdateOrderRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
        $oldOrder = $this->orderRepository->findWithoutFail($id);
        if (empty($oldOrder)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.order')]));
            return redirect(route('orders.index'));
        }
        $input = $request->except(['apply']);
        $apply = $request->apply;
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->orderRepository->model());
        try {

            if($apply==1){
                $oldOrder->partnerapply()->attach(['user_id'=>auth()->user()->id],['order_id'=>$id]);
            }
            else{
                $order = $this->orderRepository->update($input, $id);
            }
            if(isset($input['partners'])){
                foreach($input['partners'] as $partner){
                    $count=DB::table('partner_apply_orders')->where('user_id',$partner)->where('order_id',$id)->count();
                    if($count==null){
                        $oldOrder->partnerapply()->attach(['user_id'=>$partner],['order_id'=>$id]);
                    }
                }
                unset($partner);
            }
            if (setting('enable_notifications', false)) {
                if (isset($input['order_status_id']) && $input['order_status_id'] != $oldOrder->order_status_id) {
                    Notification::send([$order->user], new StatusChangedOrder($order));
                }

                if (isset($input['driver_id']) && ($input['driver_id'] != $oldOrder['driver_id'])) {
                    $driver = $this->userRepository->findWithoutFail($input['driver_id']);
                    if (!empty($driver)) {
                        Notification::send([$driver], new AssignedOrder($order));
                    }
                }
            }

            if(isset($input['status']) && $input['status']!=null){
            $this->paymentRepository->update([
                "status" => $input['status'],
            ], $order['payment_id']);
            //dd($input['status']);
                //$oldStatus = $oldOrder->payment->status;
            //event(new OrderChangedEvent($oldStatus, $order));
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $order->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.order')]));

        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified Order from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($id)
    {
        if (!env('APP_DEMO', false)) {
            $this->orderRepository->pushCriteria(new OrdersOfUserCriteria(auth()->id()));
            $order = $this->orderRepository->findWithoutFail($id);

            if (empty($order)) {
                Flash::error(__('lang.not_found', ['operator' => __('lang.order')]));

                return redirect(route('orders.index'));
            }

            $this->orderRepository->delete($id);

            Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.order')]));


        } else {
            Flash::warning('This is only demo app you can\'t change this section ');
        }
        return redirect(route('orders.index'));
    }

    /**
     * Remove Media of Order
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $order = $this->orderRepository->findWithoutFail($input['id']);
        try {
            if ($order->hasMedia($input['collection'])) {
                $order->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
