<?php

use EcomExpressAPI\API;

class TrackingTest extends \PHPUnit_Framework_TestCase
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

    public function testSingleTracking()
    {
        $this->assertArrayHasKey(102019265, $this->resource->track(102019265));
    }

    public function testMultiTracking()
    {
        $this->assertTrue(count($this->resource->track([102019267, 102019268])) === 2);
    }

    public function testInvalidTrackingNumber()
    {
        $this->assertTrue(count($this->resource->track(102019266)) === 0);
    }
}