<?php

namespace Gets\Klarna\Models;

class OrderLine
{
    const TYPE_PHYSICAL = 'physical';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_SHIPPING_FEE = 'shipping_fee';
    const TYPE_SALES_TAX = 'sales_tax';
    const TYPE_DIGITAL = 'digital';
    const TYPE_GIFT_CARD = 'gift_card';
    const TYPE_STORE_CREDIT = 'store_credit';
    const TYPE_SURCHARGE = 'surcharge';

    public string $type;
    public string $reference;
    public string $name;
    public int $quantity;
    public int $unit_price;
    public int $tax_rate;
    public int $total_amount;
    public int $total_discount_amount;
    public ?int $total_tax_amount = null;
    public string $merchant_data;
    public ?string $product_url = null;
    public ?string $image_url = null;

    public function __construct(array $data)
    {
        foreach ($data as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->$prop = $value;
            }
        }
    }

    public function toArray()
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