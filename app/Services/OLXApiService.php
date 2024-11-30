<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OLXApiService
{
    protected $client;
    protected $apiUrl = 'https://www.olx.ua/api/';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * get price advert by advert id
     * @param $adId
     * @return float
     * @throws GuzzleException
     */
    public function getPriceById($adId): float
    {
        try {
            $response = $this->client->get($this->apiUrl . "ads/{$adId}");
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['price'])) {
                return (float) $data['price'];
            }

        } catch (\Exception $e) {
            Log::error("OLX API error: " . $e->getMessage());
        }

        return 0;
    }
}
