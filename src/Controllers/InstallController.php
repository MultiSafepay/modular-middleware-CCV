<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularCCV\ModularCCV\Models\CCV;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use ModularCCV\ModularCCV\API\CCVRequest;

final class InstallController extends Controller
{
    public function view(Request $request)
    {
        $apiKey = $request->api_public;
        return view('ccv.preference', compact('apiKey'));
    }

    public function install(Request $request)
    {
        Log::info('install request data', [$request->all()]);
        $ccv = CCV::where('public_key', $request['public_key'])->first();

        $request = new CCVRequest($ccv);

        $appId = $request->getRemoteAppId();
        $request->patchInstall($appId->items[0]->id);

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

            CCV::create([
                'public_key' => $publicKey,
                'secret_key' => $secretKey,
                'domain' => $domain,
                'redirect_url' => $redirect,
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
