[![Build Status](https://travis-ci.org/albertborsos/yii2-billingo.svg?branch=master)](https://travis-ci.org/albertborsos/yii2-billingo)

Yii 2.0 Billingo component
==========================
Component to manage invoices with [billingo.hu](https://billingo.hu)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Run

```
composer require --prefer-dist albertborsos/yii2-billingo
```

Usage
-----

Once the extension is installed, set your configuration in common config file:

```php
...
    'components' => [
    ...
        'billingo' => [
            'class'      => 'albertborsos\billingo\Component',
            'publicKey'  => 'YOUR-PUBLIC-KEY',  // you should not commit into your repository
            'privateKey' => 'YOUR-PRIVATE-KEY', // you should not commit into your repository
        ],
    ...
    ],
...
```
