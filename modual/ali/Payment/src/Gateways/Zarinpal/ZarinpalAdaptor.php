<?php

namespace ali\Payment\Gateways\Zarinpal;


use ali\Payment\Contracts\GatewayContract;
use ali\Payment\Models\Payment;
use Illuminate\Http\Request;

class ZarinpalAdaptor implements GatewayContract
{
    private $url;
    private $client;

    public function request($amount, $description)
    {

        //$MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        //  $MerchantID = "4fc25c92-3382-478a-b4c8-4df428ef630a";
        $MerchantID = "4ef1d67b-4895-48bd-97ea-e284bd9f1cfa";
        $Email = "";
        $Mobile = "";
        $CallbackURL = route("payments.callback");
        $SandBox = false;


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
        //$MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $MerchantID = "4ef1d67b-4895-48bd-97ea-e284bd9f1cfa";
        $Amount = $payment->amount;
        $SandBox = false;

        $this->client = new Zarinpal();

        $result = $this->client->verify($MerchantID, $Amount, $SandBox);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            return $result["RefID"];
        } else {
            return [
                "status" => $result["Status"],
                "message" => $result["Message"]
            ];
        }
    }

    public function getName()
    {
        return "zarinpal";
    }

    public function redirect()
    {
        $this->client->redirect($this->url);
    }

    public function getInvoiceIdFromRequest(Request $request)
    {
        return $request->Authority;
    }
}
