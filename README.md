**Sending Parcel**
```php
<?php

use EcomExpressAPI\API;

$api = new API('username', 'password');

$parcel = [
    'AWB_NUMBER' => '',
    'ORDER_NUMBER' => '12345',
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

$send = $api->addParcel($parcel)->send();

if (!isset(array_shift($send)['error_list'])) {
    echo $api->addParcel($parcel)->send()['AWB_NUMBER'];
} else {
    echo array_shift($send)['error_list']['reason_comment'];
}

/*
 * [order id] => array with parcel information
 */
```

You may add multiply parcels and send as one request

```php
$api->addParcel(...)->addParcel(...)->send();

$api->addParcel(...);
$api->addParcel(...);
$api->send;
```

**Tracking**
```php
<?php

...

$tracking = $api->track(123456);
var_dump($tracking);
// ["123456"] => status array
// You should get empty array if tracking code is invalid

$tracking = $api->track([123456, 2345678, 3456789, 00000000]);
var_dump($tracking);
/*
 * ["123456"] => status array,
 * ["2345678"] => status array,
 * ["3456789"] => status array,
 * 
 * 00000000 - invalid tracking code, not included in response
 */ 
```

**Development Mode**
```php
$api->developmentMode;
```