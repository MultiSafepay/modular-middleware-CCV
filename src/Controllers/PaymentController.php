<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularCCV\ModularCCV\API\CCVRequest;
use ModularCCV\ModularCCV\Models\CCV;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;
use ModularMultiSafepay\ModularMultiSafepay\Order\CustomerInfo;
use ModularMultiSafepay\ModularMultiSafepay\Order\DeliveryInfo;
use ModularMultiSafepay\ModularMultiSafepay\Order\Item;
use ModularMultiSafepay\ModularMultiSafepay\Order\Order;
use ModularMultiSafepay\ModularMultiSafepay\Order\PaymentOptions;
use ModularMultiSafepay\ModularMultiSafepay\Order\ShoppingCart;

class PaymentController extends Controller
{
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function createTransaction(Request $request,MultiSafepay $multiSafepay){

        $ccv = CCV::where('public_key',$request->header('x-public'))->first();

        ////$ccvRequest = new CCVRequest($ccv);

        $order = json_decode($request->getContent(), true);

        $shipping = $order['shipping_address'];

        if (empty($shipping['address_line']) && empty($shipping['city'])){
            $shipping = $order['billing_address'];
        }

        $delivery = new DeliveryInfo(
            $shipping['first_name'],
            $shipping['last_name'],
            $shipping['street'],
            $shipping['house_number'],
            $shipping['postal_code'],
            $shipping['city'],
            $shipping['country'],
        );

        $billing = $order['billing_address'];

        $customer = new CustomerInfo(
            $billing['first_name'],
            $billing['last_name'],
            $order['date_of_birth'] ?? "",
            $billing['phone_number'],
            $billing['email'],
            $billing['gender'] ?? "",
            $billing['street'],
            $billing['house_number'],
            $billing['postal_code'],
            $billing['city'],
            $billing['country'],
        );

        $newOrder = new Order(
            strval($order['order_id']),
            (int)($order['amount'] * 100),
            strtoupper($order['currency']),
            $order['method'],
            'redirect',
            'M_W' . $order['order_id'],
            new PaymentOptions($order['return_url'], $order['return_url'], route('ccv.notification'), true, true),
            $customer,
            $delivery
        );

        $url = $multiSafepay->createTransaction($ccv->multisafepay_api_key, $newOrder);

        return response()->json(['pay_url' => $url], 201);
    }
}
