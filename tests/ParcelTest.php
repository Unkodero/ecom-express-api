<?php

use EcomExpressAPI\API;

class ParcelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var API
     */
    private $resource;

    public function setUp()
    {
        parent::setUp();

        $this->resource = new API(null, null);
        $this->resource->developmentMode();
    }

    public function testSingleParcel()
    {
        $this->resource->addParcel($this->generateParcel());
        $sended = $this->resource->send();

        $this->assertArrayHasKey('awb', array_shift($sended));
    }

    private function generateParcel()
    {
        return [
            "AWB_NUMBER" => "103086828",
            "ORDER_NUMBER" => rand(1, 999),
            "PRODUCT" => "COD",
            "CONSIGNEE" => "TEST",
            "CONSIGNEE_ADDRESS1" => "ADDR1",
            "CONSIGNEE_ADDRESS2" => "ADDR2",
            "CONSIGNEE_ADDRESS3" => "ADDR3",
            "DESTINATION_CITY" => "MUMBAI",
            "PINCODE"=> "400067",
            "STATE" => "MH",
            "MOBILE" => "156729",
            "TELEPHONE" => "1234",
            "ITEM_DESCRIPTION" => "MOBILE",
            "PIECES" => "1",
            "COLLECTABLE_VALUE" => "3000",
            "DECLARED_VALUE" => "3000",
            "ACTUAL_WEIGHT"=> "5",
            "VOLUMETRIC_WEIGHT"=> "0",
            "LENGTH"=> " 10",
            "BREADTH"=> "10",
            "HEIGHT"=> "10",
            "PICKUP_NAME"=> "abcde",
            "PICKUP_ADDRESS_LINE1"=> "Samalkha",
            "PICKUP_ADDRESS_LINE2"=> "kapashera",
            "PICKUP_PINCODE"    =>"110013",
            "PICKUP_PHONE"=> "98204",
            "PICKUP_MOBILE"=> "59536",
            "RETURN_PINCODE"=> "110013",
            "RETURN_NAME"=> "abcde",
            "RETURN_ADDRESS_LINE1"=> "Samalkha",
            "RETURN_ADDRESS_LINE2"=> "kapashera",
            "RETURN_PHONE"=> "98204",
            "RETURN_MOBILE" => "59536",
            "DG_SHIPMENT" => "true"
        ];
    }

    public function testMultiParcel()
    {
        $sended = $this->resource
            ->addParcel($this->generateParcel())
            ->addParcel($this->generateParcel())
            ->addParcel($this->generateParcel())
            ->send();

        $this->assertTrue(count($sended) === 3);
    }

    public function testErrorParcel()
    {
        $parcel = $this->generateParcel();
        unset($parcel['ORDER_NUMBER']);

        try {
            $this->resource->addParcel($parcel)->send();
        } catch (\EcomExpressAPI\Exception\RequestException $e) {
            $this->assertInstanceOf(EcomExpressAPI\Exception\RequestException::class, $e);
        }
    }

    public function testInvalidCredentials()
    {
        $this->resource = new API('foo', 'bar');

        try {
            $this->resource->addParcel($this->generateParcel())->send();
        } catch (\EcomExpressAPI\Exception\ApiException $e) {
            $this->assertInstanceOf(\EcomExpressAPI\Exception\ApiException::class, $e);
        }
    }

}
