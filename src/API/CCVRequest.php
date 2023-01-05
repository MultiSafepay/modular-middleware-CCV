<?php

namespace ModularCCV\ModularCCV\API;

use Carbon\Carbon;
use GuzzleHttp\Client;
use ModularCCV\ModularCCV\Models\CCV;
use Illuminate\Support\Facades\Log;

class CCVRequest
{
    protected $public;
    protected $secret;
    protected $domain;
    protected $timestamp;

    public function __construct(CCV $credentials)
    {
        $this->public = $credentials->public_key;
        $this->secret = $credentials->secret_key;
        $this->domain = $credentials->domain;
        $this->timestamp = Carbon::now('UTC')->toIso8601String();
    }


    /**
     * @param $method
     * @param $url
     * @param null $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest($method, $url, $data = null)
    {
        $hash = $this->createHash($method, $url, $data);
        $client = new Client();
        $request = $client->request($method, $this->domain . $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-date' => $this->timestamp,
                'x-hash' => $hash,
                'x-public' => $this->public,
            ],
            'body' => $data
        ]);

        //Log::info("REQUEST RESPONSE:", [$request->getBody()->getContents()]);

        return json_decode($request->getBody()->getContents());
    }

    public function getRemoteAppId()
    {
        return $this->sendRequest('GET', '/api/rest/v1/apps/');
    }

    public function patchInstall($appId)
    {
        return $this->sendRequest('PATCH', '/api/rest/v1/apps/' . $appId, json_encode(['is_installed' => true]));
    }

    public function postPaymentMethods($appId, $paymentMethods)
    {
        return $this->sendRequest('POST', '/api/rest/v1/apps/' . $appId . '/apppsp/', json_encode($paymentMethods));
    }

    public function getOrder($orderID){
        return $this->sendRequest('GET', '/api/rest/v1/orders/'.$orderID);
    }

    public function getOrderRows($orderID){
        return $this->sendRequest('GET', '/api/rest/v1/orders/'. $orderID .'/orderrows/');
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @return string
     */
    public function createHash($method, $url, $data): string
    {
        $hashString = "{$this->public}|$method|$url|$data|{$this->timestamp}";

        return hash_hmac('sha512', $hashString, $this->secret);
    }
}
