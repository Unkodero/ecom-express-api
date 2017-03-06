<?php

namespace EcomExpressAPI;

use EcomExpressAPI\Exception\RequestException;

class API
{
    const PRODUCTION_API_URL = 'http://api.ecomexpress.in';

    const DEVELOPMENT_API_URL = 'http://ecomm.prtouch.com';
    const DEVELOPMENT_API_USERNAME = 'ecomexpress';
    const DEVELOPMENT_API_PASSWORD = 'Ke$3c@4oT5m6h#$';

    /**
     * @var string Current API URL
     */
    private $API_URL;

    /**
     * @var string API Username
     */
    private $username;

    /**
     * @var string API Password
     */
    private $password;

    /**
     * @var array Parcels to send
     */
    private $parcels = [];

    /**
     * API constructor.
     * @param $username string API Username
     * @param $password string API Password
     */
    public function __construct($username, $password)
    {
        $this->API_URL = self::PRODUCTION_API_URL;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Enable development mode (use development API)
     */
    public function developmentMode()
    {
        $this->API_URL = self::DEVELOPMENT_API_URL;
        $this->username = self::DEVELOPMENT_API_USERNAME;
        $this->password = self::DEVELOPMENT_API_PASSWORD;
    }

    /**
     * Tracking parcel
     * @param $number mixed Tracking number (string or array for multiply)
     * @return array
     */
    public function track($number)
    {
        if (is_array($number)) {
            $number = implode($number, ',');
        }

        $response = $this->request('/track_me/api/mawbd/', ['awb' => $number], 'POST');

        $xmlObject = new \SimpleXMLElement($response);
        $array = [];

        foreach ($xmlObject->object as $object) {
            $awb = [];

            foreach ($object->field as $field) {
                if ($field['name'] == 'scans') {
                    $awb[(string)$field['name']] = [];

                    foreach ($field as $stageObject) {
                        $scanStage = [];

                        foreach ($stageObject->field as $stageField) {
                            $scanStage[(string)$stageField['name']] = (string)$stageField;
                        }

                        $awb[(string)$field['name']] = array_merge($awb[(string)$field['name']], [$scanStage]);
                    }
                } else {
                    $awb[(string)$field['name']] = (string)$field;
                }
            }

            $array[$awb['awb_number']] = $awb;
        }

        $this->tracking = [];

        return $array;
    }

    /**
     * Add parcel
     * @param array $parcel Parcel data
     * @return $this
     */
    public function addParcel(array $parcel)
    {
        $this->parcels[] = $parcel;
        return $this;
    }

    /**
     * Send parcel
     * @return array
     */
    public function send()
    {
        if (empty($this->parcels)) {
            return [];
        }

        $sended = [];

        foreach ($this->parcels as $parcel) {
            $xmlSource = [];
            $xmlSource[] = ['SHIPMENT' => $parcel];
            $xmlData = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="no"?><ECOMEXPRESS-OBJECTS></ECOMEXPRESS-OBJECTS>');
            $this->arrayToXML($xmlSource, $xmlData);

            $sended[$parcel['ORDER_NUMBER']];

            $response = $this->request('/api/api_create_rev_awb_xml_v3/', ['xml_input' => (string)$xmlData->asXml()], 'POST');
            
            try {
                $xmlObject = new \SimpleXMLElement($response);
            } catch (\Exception $e) {
                $sended[$parcel['ORDER_NUMBER']] = ['error_list' => ['reason_comment' => 'Error in parcel information']];
            }

            foreach ($xmlObject as $object) {
                foreach ($object->AIRWAYBILL as $field) {
                    if ((string)$field->success !== 'True') {
                        $sended[$parcel['ORDER_NUMBER']] = ['error_list' => ['reason_comment' => $field->error_list->reason_comment]];
                    } else {
                        $sended[$parcel['ORDER_NUMBER']]['AWB_NUMBER'] = (string)$field->airwaybill_number;
                    }
                }
            }
        }

        $this->parcels = [];
        return $sended;
    }

    //system functions
    /**
     * Convert array to XML
     * @param array $xmlSource
     * @param \SimpleXMLElement $xmlData
     */
    private function arrayToXML(array $xmlSource, \SimpleXMLElement &$xmlData)
    {
        foreach ($xmlSource as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subNode = $xmlData->addChild($key);
                    $this->arrayToXML($value, $subNode);
                } else {
                    $this->arrayToXML($value, $xmlData);
                }
            } else {
                $xmlData->addChild($key, $value);
            }
        }
    }

    /**
     * Guzzle wrapper to make request
     *
     * @param $method
     * @param array $parameters GET or POST parameters
     * @param string $requestMethod HTTP Request Method
     * @return string Document Body
     * @throws RequestException
     */
    private function request($method, $parameters = [], $requestMethod = 'GET')
    {
        $parameters['username'] = $this->username;
        $parameters['password'] = $this->password;

        $ch = curl_init();

        $curlOptions = [
            CURLOPT_RETURNTRANSFER => 1
        ];

        if ($requestMethod == 'POST') {
            $curlOptions[CURLOPT_URL] = $this->buildURL($this->API_URL, $method, []);
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($parameters);

            curl_setopt_array($ch, $curlOptions);

            $response = curl_exec($ch);
        } elseif ($requestMethod == 'GET') {
            curl_setopt_array($ch, $curlOptions);

            $response = curl_exec($ch);
        } else {
            throw new RequestException("Unknown HTTP request method {$requestMethod}");
        }

        return (string)$response;
    }

    /**
     * @param $uri
     * @param $location
     * @param array $parameters
     * @return string
     */
    private function buildURL($uri, $location, $parameters = [])
    {
        return $uri . $location . '?' . http_build_query($parameters);
    }
}