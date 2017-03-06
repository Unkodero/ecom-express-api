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

        $this->assertArrayHasKey('AWB_NUMBER', array_shift($sended));
    }

    public function testMultiParcel()
    {
        $sended = $this->resource
            ->addParcel($this->generateParcel())
            ->addParcel($this->generateParcel())
            ->addParcel($this->generateParcel())
            ->send();

        $this->assertTrue(count($sended) === 3);

        foreach ($sended as $parcel) {
            $this->assertArrayHasKey('AWB_NUMBER', $parcel);
        }
    }

    public function testErrorParcel()
    {
        $parcel = $this->generateParcel();
        unset($parcel['AWB_NUMBER']);

        $this->assertArrayHasKey('error_list', array_shift($this->resource->addParcel($parcel)->send()));
    }

    private function generateParcel()
    {
        return [
            'AWB_NUMBER' => '',
            'ORDER_NUMBER' => rand(111111, 9999999),
            'PRODUCT' => 'rev',
            'REVPICKUP_NAME' => 'Pia Bhatia',
            'REVPICKUP_ADDRESS1' => 'Laxmi Villa Prem Nagar Tekdi Near Swami Shanti Prakash Yoga Kendra Ashram',
            'REVPICKUP_ADDRESS2' => '',
            'REVPICKUP_ADDRESS3' => ' ',
            'REVPICKUP_CITY' => 'Thane',
            'REVPICKUP_PINCODE' => '110019',
            'REVPICKUP_STATE' => 'MAH',
            'REVPICKUP_MOBILE' => '9923919137',
            'REVPICKUP_TELEPHONE' => '9923919137',
            'ITEM_DESCRIPTION' => 'MI4I',
            'PIECES' => 1,
            'COLLECTABLE_VALUE' => '1.140',
            'DECLARED_VALUE' => '2099',
            'ACTUAL_WEIGHT' => '0.87',
            'VOLUMETRIC_WEIGHT' => '0.87',
            'LENGTH' => '320',
            'BREADTH' => '200',
            'HEIGHT' => '120',
            'VENDOR_ID' =>' ',
            'DROP_NAME' => 'Khasra No.14/14,17,18,23, 24/',
            'DROP_ADDRESS_LINE1' => 'Khasra No.14/14,17,18,23, 24/1',
            'DROP_ADDRESS_LINE2' => 'Village Khawaspur, Tehsil Farrukhnagar',
            'DROP_PINCODE' => '110019',
            'DROP_PHONE' => '9999999999',
            'DROP_MOBILE' => '8800673006',
        ];
    }

}