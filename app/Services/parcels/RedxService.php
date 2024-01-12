<?php

namespace App\Services\parcels;


use App\CPU\Helpers;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function App\CPU\callToApi;
use function App\CPU\checkNumberIsValid;
use function App\Services\getTextBetweenTags;

class RedxService
{
    public $providerName;
    public $baseUrl;
    public $accessToken;
    public function __construct()
    {
        $this->providerName = "Redx";
        $config = Helpers::get_business_settings('redx_courier');
        $accessToken = $config['access_token'];
        $environment = $config['environment'];
        if($environment == 'live') {
            $this->baseUrl = "https://openapi.redx.com.bd/v1.0.0-beta";
        } else {
            $this->baseUrl = "https://sandbox.redx.com.bd/v1.0.0-beta";
        }
        //$this->accessToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2Njg0MjMiLCJpYXQiOjE2NjQ4NTY0ODksImlzcyI6IjNGWGx3ZnBCbnFMbjN4SjZSb2JJTW8xcldRa1hVVzJNIiwic2hvcF9pZCI6NjY4NDIzLCJ1c2VyX2lkIjo2ODYzMzB9.5Ipkc1QsLcp4DtRthDHAXrNPMD18v_NKQ4kP2JoNJ3g";
        $this->accessToken = $accessToken;
    }

    public function getAreas($postCode=null)
    {
        try{
            $data = array();
            $params = [];
            if($postCode){
                $params['post_code'] = $postCode;
            }
            $headers['API-ACCESS-TOKEN'] = "Bearer ".$this->accessToken;

            $responseData = callToApi($this->baseUrl."/areas",json_encode($params),$headers,'GET');
            $responseDataArray = json_decode($responseData,true);
            $areas = isset($responseDataArray['areas']) ? $responseDataArray['areas'] : [];
            $data['areas'] = $areas;
            return $data;
        }catch (\Exception $exception){
            \Log::error($this->providerName." exception : ". $exception->getMessage(). "|| line no: ".$exception->getLine());
            return false;
        }
    }

    public function createParcel($inputData){
        try{
            $data = array();

            $params = [
                "customer_name" => isset($inputData['customer_name']) ? $inputData['customer_name'] : ' ',
                "customer_phone" => isset($inputData['customer_phone']) ? $inputData['customer_phone'] : ' ',
                "delivery_area" => isset($inputData['delivery_area']) ? $inputData['delivery_area'] : ' ',
                "delivery_area_id" => isset($inputData['delivery_area_id']) ? $inputData['delivery_area_id'] : ' ' ,
                "customer_address" => isset($inputData['customer_address']) ? $inputData['customer_address'] : ' ' ,
                "merchant_invoice_id" => isset($inputData['merchant_invoice_id']) ? $inputData['merchant_invoice_id'] : ' ' ,
                "cash_collection_amount" => isset($inputData['cash_collection_amount']) ? $inputData['cash_collection_amount'] : ' ' ,
                "parcel_weight" => isset($inputData['parcel_weight']) ? $inputData['parcel_weight'] : ' ' ,
                "instruction" => "",
                "value" => isset($inputData['value']) ? $inputData['value'] : " ",
            ];
            $headers['API-ACCESS-TOKEN'] = "Bearer ".$this->accessToken;

            $responseData = callToApi($this->baseUrl."/parcel",json_encode($params),$headers,'POST');
            $responseDataArray = json_decode($responseData,true);
            $trackingId = isset($responseDataArray['tracking_id']) ? $responseDataArray['tracking_id'] : [];
            if($trackingId == ''){
                throw new \Exception("tracking id is empty");
            }
            $data['trackingId'] = $trackingId;
            return $data;
        }catch (\Exception $exception){
            \Log::error($this->providerName." exception : ". $exception->getMessage(). "|| line no: ".$exception->getLine());
        }
    }

    public function trackParcel($trackingId){
        try{
            $data = array();
            $params = [];
            $headers['API-ACCESS-TOKEN'] = "Bearer ".$this->accessToken;

            $responseData = callToApi($this->baseUrl."/parcel/track/".$trackingId,json_encode($params),$headers,'GET');
            $responseDataArray = json_decode($responseData,true);
            $trackingInfo = isset($responseDataArray['tracking']) ? $responseDataArray['tracking'] : [];
            $data['tracking_info'] = $trackingInfo;
            return $data;
        }catch (\Exception $exception){
            \Log::error($this->providerName." exception : ". $exception->getMessage(). "|| line no: ".$exception->getLine());
            return false;
        }
    }

    public function infoParcel($trackingId){
        try{
            $data = array();
            $params = [];
            $headers['API-ACCESS-TOKEN'] = "Bearer ".$this->accessToken;

            $responseData = callToApi($this->baseUrl."/parcel/info/".$trackingId,json_encode($params),$headers,'GET');

            $responseDataArray = json_decode($responseData,true);
            $parcelData = isset($responseDataArray['parcel']) ? $responseDataArray['parcel'] : [];
            $data['parcel_info'] = $parcelData;
            return $data;
        }catch (\Exception $exception){
            \Log::error($this->providerName." exception : ". $exception->getMessage(). "|| line no: ".$exception->getLine());
            return false;
        }
    }
}
