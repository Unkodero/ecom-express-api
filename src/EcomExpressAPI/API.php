<?php

namespace EcomExpressAPI;

use EcomExpressAPI\Exception\ApiException;
use EcomExpressAPI\Exception\RequestException;

/**
 * Class API
 * @package EcomExpressAPI
 */
class API
{
    const PRODUCTION_API_URL = 'http://plapi.ecomexpress.in';

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
     * Get all pincodes
     * @return mixed
     */
    public function getPinList()
    {
        return json_decode($this->request('/apiv2/pincodes/'), true);
    }

    /**
     * Wrapper to make request
     *
     * @param $method
     * @param array $parameters POST parameters
     * @return string Document Body
     * @throws ApiException
     */
    private function request($method, $parameters = [])
    {
        $parameters['username'] = $this->username;
        $parameters['password'] = $this->password;

        $ch = curl_init();

        $curlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->API_URL . $method,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($parameters)
        ];

        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);

        if (preg_match('/Unauthorised/i', $response)) {
            throw new ApiException('Invalid API credentials');
        }

        return (string)$response;
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

        $response = $this->request('/track_me/api/mawbd/', ['awb' => $number]);

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
     * @return array|string
     * @throws RequestException
     */
    public function send()
    {
        if (empty($this->parcels)) {
            return [];
        }

        $codes = $this->getAwbNumbers(count($this->parcels));

        foreach ($this->parcels as &$parcel) {
            $parcel['AWB_NUMBER'] = (string)end($codes);
            unset($codes[count($codes)-1]);
        }

        $response = $this->request('/apiv2/manifest_awb/', ['json_input' => json_encode($this->parcels)]);

        $response = json_decode($response, true);

        if ($response == null) {
            throw new RequestException('Request Exception: invalid parcel data');
        }

        $this->parcels = [];

        return $response['shipments'];
    }

    /**
     * Get AWB numbers
     * @param int $count
     * @return mixed
     * @throws \Exception
     */
    public function getAwbNumbers($count = 1)
    {
        $codes = json_decode($this->request('/apiv2/fetch_awb/', ['count' => $count, 'type' => 'COD']), true);

        if ($codes['success'] == 'no') {
            throw new ApiException("AWB Get error: {$codes['error'][0]}");
        }


        return $codes['awb'];
    }
}
