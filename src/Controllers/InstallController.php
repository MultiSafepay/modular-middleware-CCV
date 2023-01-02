<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularCCV\ModularCCV\Models\CCV;
use ModularCCV\ModularCCV\API\CCVRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;

final class InstallController extends Controller
{
    public function view(Request $request)
    {
        $apiKey = $request->api_public;

        return view('ccv.api', compact('apiKey'));
    }

    public function install(Request $request, MultiSafepay $multiSafepay)
    {
        Log::info('install request data', [$request->all()]);
        $ccv = CCV::where('public_key', $request['public_key'])->first();
        $ccv->multisafepay_api_key = $request['api_key'];
        $ccv->multisafepay_environment = $request['environment'];

        $ccv->save();
        
        $ccvRequest = new CCVRequest($ccv);
        $appId = $ccvRequest->getRemoteAppId()->items[0]->id;
        $ccvRequest->patchInstall($appId);

        $paymentMethods = $multiSafepay->getPaymentMethods($ccv->multisafepay_api_key);
        $ccvPaymentMethods = [];
        $ccvPaymentMethods['name'] = "MultiSafepay";
        $ccvPaymentMethods['description'] = "MultiSafepay Payment Service provider";
        $ccvPaymentMethods['endpoint'] = route('ccv.payment');

        $allowedCurrencies = [
            'EUR',
            'CHF',
            'USD',
            'GBP',
            'TRY',
            'CAD',
            'SRD',
            'DKK',
            'RON',
            'SEK',
        ];

        foreach ($paymentMethods as $paymentMethod)
        {
            $currencies = array_intersect($allowedCurrencies, $paymentMethod->allowedCurrencies);
            $ccvPaymentMethod = [];
            $ccvPaymentMethod['id'] = $paymentMethod->id;
            $ccvPaymentMethod['name'] = $paymentMethod->name;
            $ccvPaymentMethod['icon'] = $paymentMethod->iconUrl;
            $ccvPaymentMethod['type'] = 'postsale';
            $ccvPaymentMethod['currencies'] = array_values($currencies);
            $ccvPaymentMethod['required_fields'] = [];
            $ccvPaymentMethod['issuers'] = [];

//            if ($paymentMethod['hasComponent'])
//            {
//                $ccvPaymentMethod['required_fields'] = $paymentMethod['currencies'];
//                $ccvPaymentMethod['issuers'] = [
//                    'id' => '',
//                    'name' => ''
//                ];
//            }
            $ccvPaymentMethods['paymethods'][] = $ccvPaymentMethod;
        }

        Log::info('paymentMethods', [$ccvPaymentMethods]);
        $ccvRequest->postPaymentMethods($appId, $ccvPaymentMethods);

        return redirect()->to($ccv->redirect_url);
    }

    public function handshake(Request $request)
    {
        $hashData = [
            route('ccv.setup.handshake'),
            $request->getContent()
        ];

        $hashString = implode('|', $hashData);

        $secret = config('ccv.secret');

        $hash = hash_hmac('sha512', $hashString, $secret);

        if ($request->header('x-hash') === $hash) {
            $publicKey = $request['api_public'];
            $secretKey = $request['api_secret'];
            $domain = $request['api_root'];
            $redirect = $request['return_url'];
            //check if domain already exist.
            CCV::updateOrCreate(
                [
                    'domain' => $domain,
                ],
                [
                    'public_key' => $publicKey,
                    'secret_key' => $secretKey,
                    'domain' => $domain,
                    'redirect_url' => $redirect
                ]);
            return;
        }

        Log::error('Hash did not match for public key:', [
            'public_key' => $request['api_public'],
            'api_root' => $request['api_root']
        ]);
    }

    public function uninstall(Request $request)
    {
        Log::info('Uninstall request data', [$request->all()]);

        return response("OK");
    }


}
