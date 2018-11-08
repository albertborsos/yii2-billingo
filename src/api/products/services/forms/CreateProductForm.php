<?php

namespace albertborsos\billingo\api\products\services\forms;

use albertborsos\billingo\api\AbstractApiDataForm;

class CreateProductForm extends AbstractApiDataForm
{
    public $name;
    public $price;
    public $unit;
    public $currency_code;
    public $vat_id;
    public $fokonyv_arbev;
    public $fokonyv_afa;

    // optional fields
    public $comment;
    public $categories_id;
    public $parent_product_id;
    public $min_qty;
    public $max_qty;
    public $opt_qty;
    public $is_service;
    public $barcode;
    public $product_code;
    public $item_nr;
    public $width;
    public $height;
    public $depth;
    public $weight;
    public $description;
    public $master_variation_id;
}
