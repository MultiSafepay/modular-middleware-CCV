<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function __invoke(Request $request)
    {
//        Log::info("Dispatching CCV Notification job",[
//            'Request' => $request->all(),
//            'Lightspeed' => $Lightspeed,
//            'Order ID' => $request->order_id
//        ]);
//        NotificationJob::dispatch($request->all(),$Lightspeed, $LightspeedClient)->onQueue('LightspeedNotifications')->delay(now()->addSeconds(5));
        return response('OK');
    }
}
