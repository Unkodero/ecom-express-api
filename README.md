# EcomExpress API
[![Build Status](https://travis-ci.org/Unkodero/ecom-express-api.svg?branch=master)](https://travis-ci.org/Unkodero/ecom-express-api)

https://ecomexpress.in/ Wrapper

## Install
```
composer require unkodero/ecom-express-api
```

## Usage
```php
<?php

use EcomExpressAPI\API as Post;

$api = new Post('username', 'password');
```

### Development Mode
```php
//You may insert any credetinals to API constructor
$api->developmentMode();
```

### Tracking
```php
<?php

...

$tracking = $api->track(102019265);
$tracking = $api->track([123, 456, 789]); //multiply

//See below answers examples
```

### Getting Pincodes
```php
$pin = $api->getPinList();
```

### Parcel sending
```php

...

$parcel = [
    "AWB_NUMBER" => "",
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
                  
$send = $api->addParcel($parcel)->send();             
```

You may add multiply parcels and send as one request

```php
$api->addParcel(...)->addParcel(...)->send();

$api->addParcel(...);
$api->addParcel(...);
$api->send;
```

### Answers
**Pincodes**
```php
  ...
  [0]=>
  array(9) {
    ["city"]=>
    string(6) "MUMBAI"
    ["state"]=>
    string(11) "Maharashtra"
    ["active"]=>
    bool(true)
    ["route"]=>
    string(6) "MH/MUM"
    ["date_of_discontinuance"]=>
    NULL
    ["state_code"]=>
    string(2) "MH"
    ["pincode"]=>
    int(400041)
    ["city_code"]=>
    string(3) "MUM"
    ["dccode"]=>
    string(3) "BOM"
  }
  ...
```

**Parcel sending**
```php
array (
    0 => 
    array (
      'reason' => 'AIRWAYBILL_NUMBER_ALREADY_EXISTS',
      'order_number' => '7677',
      'awb' => '103086824',
      'success' => false,
    ),
    1 => 
    array (
      'reason' => '',
      'order_number' => '7677',
      'awb' => '103086825',
      'success' => true,
    ),
  ),=
```

**Tracking**
````php
array(1) {
  [102019265]=>
  array(29) {
    ["awb_number"]=>
    string(9) "102019265"
    ["orderid"]=>
    string(7) "8008444"
    ["actual_weight"]=>
    string(3) "2.0"
    ["origin"]=>
    string(9) "DELHI-DSW"
    ["destination"]=>
    string(12) "Mumbai - BOW"
    ["current_location_name"]=>
    string(12) "Mumbai - BOW"
    ["current_location_code"]=>
    string(3) "BOW"
    ["customer"]=>
    string(36) "Ecom Express Private Limited - 32012"
    ["consignee"]=>
    string(14) "BEECHAND VERMA"
    ["pickupdate"]=>
    string(11) "22-Jan-2014"
    ["status"]=>
    string(11) "Undelivered"
    ["tracking_status"]=>
    string(11) "Undelivered"
    ["reason_code"]=>
    string(33) "221 - Consignee Refused To Accept"
    ["reason_code_description"]=>
    string(27) "Consignee Refused To Accept"
    ["reason_code_number"]=>
    string(3) "221"
    ["comments"]=>
    string(0) ""
    ["receiver"]=>
    string(0) ""
    ["expected_date"]=>
    string(11) "15-Feb-2014"
    ["last_update_date"]=>
    string(11) "28-Mar-2014"
    ["delivery_date"]=>
    string(0) ""
    ["ref_awb"]=>
    string(9) "703063993"
    ["rts_shipment"]=>
    string(1) "0"
    ["system_delivery_update"]=>
    string(0) ""
    ["rts_system_delivery_status"]=>
    string(11) "Undelivered"
    ["rts_reason_code_number"]=>
    string(0) ""
    ["pincode"]=>
    string(6) "400037"
    ["city"]=>
    string(6) "MUMBAI"
    ["state"]=>
    string(11) "Maharashtra"
    ["scans"]=>
    array(41) {
      [0]=>
      array(10) {
        ["updated_on"]=>
        string(23) "28 Mar, 2014, 22:43 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [1]=>
      array(10) {
        ["updated_on"]=>
        string(23) "26 Mar, 2014, 20:06 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [2]=>
      array(10) {
        ["updated_on"]=>
        string(23) "25 Mar, 2014, 21:37 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [3]=>
      array(10) {
        ["updated_on"]=>
        string(23) "24 Mar, 2014, 20:52 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [4]=>
      array(10) {
        ["updated_on"]=>
        string(23) "22 Mar, 2014, 21:23 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [5]=>
      array(10) {
        ["updated_on"]=>
        string(23) "21 Mar, 2014, 22:13 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [6]=>
      array(10) {
        ["updated_on"]=>
        string(23) "20 Mar, 2014, 20:55 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [7]=>
      array(10) {
        ["updated_on"]=>
        string(23) "19 Mar, 2014, 19:08 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(31) "Shelke  Pandurang Baburao-11024"
      }
      [8]=>
      array(10) {
        ["updated_on"]=>
        string(23) "16 Mar, 2014, 21:07 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [9]=>
      array(10) {
        ["updated_on"]=>
        string(23) "15 Mar, 2014, 20:27 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [10]=>
      array(10) {
        ["updated_on"]=>
        string(23) "14 Mar, 2014, 20:32 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [11]=>
      array(10) {
        ["updated_on"]=>
        string(23) "13 Mar, 2014, 19:03 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [12]=>
      array(10) {
        ["updated_on"]=>
        string(23) "11 Mar, 2014, 20:30 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [13]=>
      array(10) {
        ["updated_on"]=>
        string(23) "09 Mar, 2014, 20:09 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [14]=>
      array(10) {
        ["updated_on"]=>
        string(23) "08 Mar, 2014, 19:42 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [15]=>
      array(10) {
        ["updated_on"]=>
        string(23) "07 Mar, 2014, 19:45 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [16]=>
      array(10) {
        ["updated_on"]=>
        string(23) "04 Mar, 2014, 21:09 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [17]=>
      array(10) {
        ["updated_on"]=>
        string(23) "03 Mar, 2014, 20:41 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [18]=>
      array(10) {
        ["updated_on"]=>
        string(23) "27 Feb, 2014, 23:12 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [19]=>
      array(10) {
        ["updated_on"]=>
        string(23) "25 Feb, 2014, 23:26 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [20]=>
      array(10) {
        ["updated_on"]=>
        string(23) "24 Feb, 2014, 22:43 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [21]=>
      array(10) {
        ["updated_on"]=>
        string(23) "23 Feb, 2014, 20:38 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [22]=>
      array(10) {
        ["updated_on"]=>
        string(23) "20 Feb, 2014, 20:35 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(31) "Shelke  Pandurang Baburao-11024"
      }
      [23]=>
      array(10) {
        ["updated_on"]=>
        string(23) "18 Feb, 2014, 20:43 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [24]=>
      array(10) {
        ["updated_on"]=>
        string(23) "17 Feb, 2014, 21:13 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--221"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [25]=>
      array(10) {
        ["updated_on"]=>
        string(23) "17 Feb, 2014, 14:21 hrs"
        ["status"]=>
        string(61) "Shipment out for delivery, assigned to Employee Prabhat singh"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--006"
        ["scan_status"]=>
        string(3) "OUT"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [26]=>
      array(10) {
        ["updated_on"]=>
        string(23) "16 Feb, 2014, 19:56 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "227"
        ["reason_code_number"]=>
        string(5) "--227"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [27]=>
      array(10) {
        ["updated_on"]=>
        string(23) "15 Feb, 2014, 21:51 hrs"
        ["status"]=>
        string(21) "Shipment un-delivered"
        ["reason_code"]=>
        string(3) "227"
        ["reason_code_number"]=>
        string(5) "--227"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "Prabhat singh-11402"
      }
      [28]=>
      array(10) {
        ["updated_on"]=>
        string(23) "15 Feb, 2014, 08:58 hrs"
        ["status"]=>
        string(73) "Shipment out for delivery, assigned to Employee Shelke  Pandurang Baburao"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--006"
        ["scan_status"]=>
        string(3) "OUT"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(31) "Shelke  Pandurang Baburao-11024"
      }
      [29]=>
      array(10) {
        ["updated_on"]=>
        string(23) "15 Feb, 2014, 08:34 hrs"
        ["status"]=>
        string(22) "Shipment in-scan at DC"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--005"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BOW"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(31) "Shelke  Pandurang Baburao-11024"
      }
      [30]=>
      array(10) {
        ["updated_on"]=>
        string(23) "13 Feb, 2014, 17:36 hrs"
        ["status"]=>
        string(54) "Shipment connected to Mumbai - BOW (Bag No. BOW454002)"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--003"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOG"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "SOMNATH Godse-11458"
      }
      [31]=>
      array(10) {
        ["updated_on"]=>
        string(23) "13 Feb, 2014, 17:36 hrs"
        ["status"]=>
        string(16) "Shipment in-scan"
        ["reason_code"]=>
        string(3) "207"
        ["reason_code_number"]=>
        string(5) "--002"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BOG"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "SOMNATH Godse-11458"
      }
      [32]=>
      array(10) {
        ["updated_on"]=>
        string(23) "13 Feb, 2014, 17:35 hrs"
        ["status"]=>
        string(33) "Redirection under Same Airwaybill"
        ["reason_code"]=>
        string(3) "207"
        ["reason_code_number"]=>
        string(5) "--207"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BOG"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "SOMNATH Godse-11458"
      }
      [33]=>
      array(10) {
        ["updated_on"]=>
        string(23) "13 Feb, 2014, 09:30 hrs"
        ["status"]=>
        string(22) "Shipment in-scan at DC"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--005"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BOG"
        ["location_city"]=>
        string(6) "MUMBAI"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "MUMBAI"
        ["Employee"]=>
        string(19) "SOMNATH Godse-11458"
      }
      [34]=>
      array(10) {
        ["updated_on"]=>
        string(23) "11 Feb, 2014, 20:47 hrs"
        ["status"]=>
        string(42) "Bag ready for connection (Run Code: 91808)"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--004"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [35]=>
      array(10) {
        ["updated_on"]=>
        string(23) "11 Feb, 2014, 15:16 hrs"
        ["status"]=>
        string(54) "Shipment connected to MUMBAI - BOH (Bag No. BOG447438)"
        ["reason_code"]=>
        string(0) ""
        ["reason_code_number"]=>
        string(5) "--003"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [36]=>
      array(10) {
        ["updated_on"]=>
        string(23) "11 Feb, 2014, 15:00 hrs"
        ["status"]=>
        string(16) "Shipment in-scan"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--002"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [37]=>
      array(10) {
        ["updated_on"]=>
        string(23) "11 Feb, 2014, 14:59 hrs"
        ["status"]=>
        string(16) "Shipment in-scan"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--002"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [38]=>
      array(10) {
        ["updated_on"]=>
        string(23) "05 Feb, 2014, 16:30 hrs"
        ["status"]=>
        string(16) "Shipment in-scan"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--002"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [39]=>
      array(10) {
        ["updated_on"]=>
        string(23) "05 Feb, 2014, 16:30 hrs"
        ["status"]=>
        string(16) "Shipment in-scan"
        ["reason_code"]=>
        string(3) "221"
        ["reason_code_number"]=>
        string(5) "--002"
        ["scan_status"]=>
        string(2) "IN"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
      [40]=>
      array(10) {
        ["updated_on"]=>
        string(23) "22 Jan, 2014, 12:50 hrs"
        ["status"]=>
        string(18) "Shipment Picked Up"
        ["reason_code"]=>
        string(3) "777"
        ["reason_code_number"]=>
        string(6) "--0011"
        ["scan_status"]=>
        string(4) "HOLD"
        ["location"]=>
        string(3) "BDQ"
        ["location_city"]=>
        string(6) "BARODA"
        ["location_type"]=>
        string(14) "Service Centre"
        ["city_name"]=>
        string(6) "BARODA"
        ["Employee"]=>
        string(18) "Nikhil Karia-10818"
      }
    }
  }
}
````
