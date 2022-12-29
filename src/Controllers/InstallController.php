<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ModularCCV\ModularCCV\Models\CCV;

final class InstallController extends Controller
{
    public function install(Request $request)
    {
        Log::info('install request data',[$request]);

        return response("OK");
    }

    public function handshake(Request $request){
        $public_key = $request['api_public'];
        $secret_key = $request['api_secret'];
        $domain = $request['api_root'];

        $check = CCV::where('public_key',$public_key)->first();

        if ($check){
            CCV::create([
                'public_key' => $public_key,
                'secret_key' => $secret_key,
                'domain' => $domain,
            ]);
        }

        return response("OK");
    }

    public function uninstall(Request $request){

        Log::info('Uninstall request data',[$request]);

        return response("OK");
    }


}
