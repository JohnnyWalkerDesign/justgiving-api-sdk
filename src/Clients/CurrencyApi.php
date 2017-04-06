<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

class CurrencyApi extends ClientBase
{
    public function ValidCurrencies()
    {
        $url = "fundraising/currencies";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
