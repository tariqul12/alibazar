<?php

namespace App\Services\paymentMethods;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function App\CPU\callToApi;

class PortwalletService
{
    public $apiKey;
    public $secretKey;
    public $mode;
    public $baseUrl;
    public function __construct($apiKey,$secretKey,$mode)
    {
        if($mode == 'live'){
            $this->baseUrl = "https://api.portwallet.com/payment/v2";
        } else {
            $this->baseUrl = "https://api-sandbox.portwallet.com/payment/v2";
        }
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;

    }

    public function initPayment($inputData)
    {
       try{
           $authorization = base64_encode($this->apiKey.':'.md5($this->secretKey.time()));
           $headerData['Authorization'] = 'Bearer ' . $authorization;
           $paymentUrl = $this->baseUrl.'/invoice';

           $paymentData = json_encode($inputData);
           $responseData = callToApi($paymentUrl,$paymentData,$headerData,'POST');
           \Log::info("init payment data : ".json_encode($responseData));
          return $responseData;
       }catch (\Exception $exception){
           \Log::error("init payment error: ". $exception->getMessage());
           return false;
       }
    }

    public function queryPayment($invoiceId) {
        try{
            $authorization = base64_encode($this->apiKey.':'.md5($this->secretKey.time()));
            $headerData['Authorization'] = 'Bearer ' . $authorization;
            $paymentUrl = $this->baseUrl.'/invoice/'.$invoiceId;

            $responseData = callToApi($paymentUrl,'',$headerData,'GET');
            \Log::info("Query payment data : ".json_encode($responseData));
            return $responseData;
        }catch (\Exception $exception){
            \Log::error("init payment error: ". $exception->getMessage());
            return false;
        }
    }
}
