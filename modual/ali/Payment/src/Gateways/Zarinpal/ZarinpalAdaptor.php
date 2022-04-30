<?php

namespace ali\Payment\Gateways\Zarinpal;


use ali\Payment\Contracts\GatewayContract;
use ali\Payment\Models\Payment;

class ZarinpalAdaptor implements GatewayContract
{
    private $url;
    private $client;

    public function request($amount, $description)
    {


        $MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Email = "";
        $Mobile = "";
        $CallbackURL = "http://momtaz.me/test-verify";
        $SandBox = true;


        $this->client = new Zarinpal();
        $result = $this->client->request($MerchantID, $amount, $description, $Email, $Mobile, $CallbackURL, $SandBox);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            $this->url = $result["StartPay"];
            return $result['Authority'];
        } else {

            return [
                "status" => $result["Status"],
                "message" => $result["Message"]
            ];
        }
    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }

    public function getName()
    {
        return "zarinpal";
    }

    public function redirect()
    {
        $this->client->redirect($this->url);
    }
}
