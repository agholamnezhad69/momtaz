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


        $MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Email = "";
        $Mobile = "";
        $CallbackURL = route("payments.callback");
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
        $MerchantID = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Amount = $payment->amount;
        $SandBox = true;

        $this->client = new Zarinpal();

        $result = $this->client->verify($MerchantID, $Amount, $SandBox);

        if (isset($result["Status"]) && $result["Status"] == 100)
        {
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
