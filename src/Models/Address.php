<?php

namespace Gets\Klarna\Models;
use Gets\Klarna\Traits\Fillable;

class Address
{
    use Fillable;

    public $given_name;
    public $family_name;
    public $title;
    public $street_address;
    public $street_address2;
    public $postal_code;
    public $city;
    public $region;
    public $country;
    public $email;
    public $phone;

    public function toArray(): array
    {
        return [
            'given_name'      => $this->given_name,
            'family_name'     => $this->family_name,
            'title'           => $this->title,
            'street_address'  => $this->street_address,
            'street_address2' => $this->street_address2,
            'postal_code'     => $this->postal_code,
            'city'            => $this->city,
            'region'          => $this->region,
            'country'         => $this->country,
            'email'           => $this->email,
            'phone'           => $this->phone,
        ];
    }
}