<?php

namespace Karim007\LaravelNagad\Payment;

use Carbon\Carbon;
use Karim007\LaravelNagad\Traits\Helpers;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Karim007\LaravelNagad\Exception\NagadException;
use Karim007\LaravelNagad\Exception\InvalidPublicKey;
use Karim007\LaravelNagad\Exception\InvalidPrivateKey;
use Illuminate\Contracts\Foundation\Application;

class Payment extends BaseApi
{
    /**
     * initialize payment
     *
     * @param $invoice
     *
     * @return mixed
     * @throws NagadException
     * @throws InvalidPrivateKey
     * @throws InvalidPublicKey
     */
    private function initPayment($invoice)
    {
        $baseUrl       = $this->baseUrl . "check-out/initialize/" . config("nagad.merchant_id") . "/{$invoice}";
        $sensitiveData = $this->getSensitiveData($invoice);
        $body          = [
            "accountNumber" => config("nagad.merchant_number"),
            "dateTime"      => Carbon::now()->timezone(config("timezone"))->format('YmdHis'),
            "sensitiveData" => $this->encryptWithPublicKey(json_encode($sensitiveData)),
            'signature'     => $this->signatureGenerate(json_encode($sensitiveData)),
        ];

        $response = Http::withHeaders($this->headers())->post($baseUrl, $body);
        //dd($response);
        $response = json_decode($response->body());
        //dd($response);
        if (isset($response->reason)) {
            throw new NagadException($response->message);
        }

        return $response;
    }


    /**
     * Create payment
     *
     * @param float $amount
     * @param string $invoice
     *
     * @return mixed
     * @throws InvalidPrivateKey
     * @throws InvalidPublicKey
     * @throws NagadException
     */
    public function create($amount, $invoice)
    {
        $initialize = $this->initPayment($invoice);

        if ($initialize->sensitiveData && $initialize->signature) {
            $decryptData        = json_decode($this->decryptDataPrivateKey($initialize->sensitiveData));
            $url                = $this->baseUrl . "/check-out/complete/" . $decryptData->paymentReferenceId;
            $sensitiveOrderData = [
                'merchantId'   => config("nagad.merchant_id"),
                'orderId'      => $invoice,
                'currencyCode' => '050',
                'amount'       => $amount,
                'challenge'    => $decryptData->challenge
            ];

            $response = Http::withHeaders($this->headers())
                ->post($url, [
                    'sensitiveData'       => $this->encryptWithPublicKey(json_encode($sensitiveOrderData)),
                    'signature'           => $this->signatureGenerate(json_encode($sensitiveOrderData)),
                    'merchantCallbackURL' => config("nagad.callback_url"),
                ]);
            $response = json_decode($response->body());
            if (isset($response->reason)) {
                throw new NagadException($response->message);
            }

            return $response;
        }
    }

    public function executePayment($amount, $invoice)
    {
        $response = $this->create($amount, $invoice);
        if ($response->status == "Success") {
            return redirect($response->callBackUrl);
        }
    }

    /**
     * Verify Payment
     *
     * @param string $paymentRefId
     *
     * @return mixed
     */
    public function verify(string $paymentRefId)
    {
        $url      = $this->baseUrl . "verify/payment/{$paymentRefId}";
        $response = Http::withHeaders($this->headers())->get($url);
        return json_decode($response->body());
    }

}
