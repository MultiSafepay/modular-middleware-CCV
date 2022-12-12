<?php declare(strict_types=1);

namespace ModularCCV\ModularCCV\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class InstallController extends Controller
{
    public function install(Request $request){
        return response("OK");
    }

    public function handshake(Request $request){

    }

    public function uninstall(Request $request){

    }


}
