<?php

namespace Gets\Klarna\Models;

use Fillable;

class ShippingInfo
{
    use Fillable;

    public const SHIPPING_METHOD_PICK_UP_STORE = 'PickUpStore';
    public const SHIPPING_METHOD_HOME = 'Home';
    public const SHIPPING_METHOD_BOX_REG = 'BoxReg';
    public const SHIPPING_METHOD_BOX_UNREG = 'BoxUnreg';
    public const SHIPPING_METHOD_PICK_UP_POINT = 'PickUpPoint';
    public const SHIPPING_METHOD_OWN = 'Own';
    public const SHIPPING_METHOD_POSTAL = 'Postal';
    public const SHIPPING_METHOD_DHL_PACKSTATION = 'DHLPackstation';
    public const SHIPPING_METHOD_DIGITAL = 'Digital';
    public const SHIPPING_METHOD_UNDEFINED = 'Undefined';

    public $shipping_company;
    public $shipping_method;
    public $tracking_number;
    public $tracking_uri;

    public $return_shipping_company;
    public $return_tracking_number;
    public $return_tracking_uri;

    public function __construct(array $shippingInfo)
    {
        $this->fillFromArray($shippingInfo);
    }
}
