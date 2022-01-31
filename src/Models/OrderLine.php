<?php

namespace Gets\Klarna\Models;

use Fillable;

class OrderLine
{
    use Fillable;

    public const TYPE_PHYSICAL = 'physical';
    public const TYPE_DISCOUNT = 'discount';
    public const TYPE_SHIPPING_FEE = 'shipping_fee';
    public const TYPE_SALES_TAX = 'sales_tax';
    public const TYPE_DIGITAL = 'digital';
    public const TYPE_GIFT_CARD = 'gift_card';
    public const TYPE_STORE_CREDIT = 'store_credit';
    public const TYPE_SURCHARGE = 'surcharge';

    public $type;
    public $reference;
    public $name;
    public $quantity;
    public $unit_price;
    public $tax_rate;
    public $total_amount;
    public $total_discount_amount;
    public $total_tax_amount;
    public $merchant_data;
    public $product_url;
    public $image_url;

    public function __construct(array $orderLine)
    {
        $this->fillFromArray($orderLine);
    }

    public function toArray(): array
    {
        return [
            'type'                  => $this->type,
            'reference'             => $this->reference,
            'name'                  => $this->name,
            'quantity'              => $this->quantity,
            'unit_price'            => $this->unit_price,
            'tax_rate'              => $this->tax_rate,
            'total_amount'          => $this->total_amount,
            'total_discount_amount' => $this->total_discount_amount,
            'total_tax_amount'      => $this->total_tax_amount,
            'merchant_data'         => $this->merchant_data,
            'product_url'           => $this->product_url,
            'image_url'             => $this->image_url,
        ];
    }
}
