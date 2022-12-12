<?php

class CCVRequestData
{
    protected $api;
    protected $client;

    public function __contruct($api,$client)
    {
        $this->api = $api;
        $this->client = $client;
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
        $request = $this->client->request($method, $this->api['domain'] . $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-date' => $this->api['timestamp'],
                'x-hash' => $hash,
                'x-public' => $this->api['public'],
            ],
            'body' => $data
        ]);

        return json_decode($request->getBody()->getContents());
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @return string
     */
    public function createHash($method, $url, $data): string
    {
        $hashString = "{$this->api['public']}|$method|$url|$data|{$this->api['timestamp']}";

        return hash_hmac('sha512', $hashString, $this->api['secret']);
    }
}
