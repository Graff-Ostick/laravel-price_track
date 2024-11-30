<?php

namespace App\Services;

use Goutte\Client;
use Illuminate\Support\Facades\Log;

class OLXParserService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * get price from URL
     */
    public function getPriceFromUrl($url)
    {
        try {
            $crawler = $this->client->request('GET', $url);
            $price = $crawler->filter('.price')->text(); // todo check identifier
            $price = preg_replace('/[^\d.]/', '', $price);
            return $price ?: (float) $price;

        } catch (\Exception $e) {
            Log::error("Parsing OLX page error: " . $e->getMessage());
            return null;
        }
    }
}
