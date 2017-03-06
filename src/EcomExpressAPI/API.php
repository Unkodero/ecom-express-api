<?php

namespace EcomExpressAPI;

use \GuzzleHttp\Client as HttpClient;
use EcomExpressAPI\Exception\RequestException;

class API
{
    const PRODUCTION_API_URL = 'http://api.ecomexpress.in';

    const DEVELOPMENT_API_URL = 'http://ecomm.prtouch.com';
    const DEVELOPMENT_API_USERNAME = 'ecomexpress';
    const DEVELOPMENT_API_PASSWORD = 'Ke$3c@4oT5m6h#$';

    /**
     * @var HttpClient
     */
    private $httpClient;

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

        $this->httpClient = new HttpClient();
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
        if(is_array($number)) {
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

            try {
                $response = $this->request('/api/api_create_rev_awb_xml_v3/', ['xml_input' => (string)$xmlData->asXml()], 'POST');
            } catch (RequestException $e) {
                $sended[$parcel['ORDER_NUMBER']] = ['error_list' => ['reason_comment' => 'Error in parcel information']];
                continue;
            }

            $xmlObject = new \SimpleXMLElement($response);

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

        try {
            if ($requestMethod == 'POST') {
                $response = $this->httpClient->request($requestMethod, $this->buildURL($this->API_URL, $method, []), ['form_params' => $parameters]);
            } elseif ($requestMethod == 'GET') {
                $response = $this->httpClient->request($requestMethod, $this->buildURL($this->API_URL, $method, $parameters));
            } else {
                throw new RequestException("Unknown HTTP request method {$requestMethod}");
            }
            //Doh!
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new RequestException($e->getMessage());
        }  catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new RequestException($e->getMessage());
        }  catch (\GuzzleHttp\Exception\BadResponseException $e) {
            throw new RequestException($e->getMessage());
        }

        if ((int)$response->getStatusCode() !== 200) {
            throw new RequestException((string)$response->getBody());
        }

        return (string)$response->getBody();
    }

    /**
     * @param $uri
     * @param $location
     * @param array $parameters
     * @return string
     */
    private function buildURL($uri, $location, $parameters = [])
    {
        return $uri . $location .  '?' . http_build_query($parameters);
    }
}