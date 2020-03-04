<?php

require "Coin.php";
require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => "mysql",
    'host' => "localhost",
    'database' => "redbit",
    'username' => "root",
    'password' => ""
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

require "Payment.php";

$coin = new CoinPaymentsAPI();
// private key\\pubblic key
$coin->Setup("40325d9B97023f1c619BB289dcad3b26F5A78128e5Ec8cE5dCd94e382a550D22","b078717bdc14eac08f886c7f6fa23845b37116c311567a7ec4ed69d7118e1968");