<?php

namespace albertborsos\billingo\api\clients\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class BillingAddressForm extends AbstractApiDataForm
{
    public $street_name;
    public $street_type;
    public $house_nr;
    public $block;
    public $entrance;
    public $floor;
    public $door;
    public $city;
    public $postcode;
    public $district;
    public $country;
}
