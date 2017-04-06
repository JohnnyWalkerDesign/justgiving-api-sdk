<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class DonationApi extends ClientBase
{
    public function Retrieve($donationId)
    {
        $url = "donation/" . $donationId;

        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function RetrieveV2($donationId)
    {
        $httpResponse = new HTTPResponse();
        $url = "donation/" . $donationId;

        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function RetrieveStatus($donationId)
    {
        $url = "donation/" . $donationId . "/status";

        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function RetrieveDetails($thirdPartReference)
    {
        $url = "donation/ref/" . $thirdPartReference;

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
