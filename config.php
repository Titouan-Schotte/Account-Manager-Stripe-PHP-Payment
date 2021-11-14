<?php
$CREATE_ACCOUNT_ON_DB = true;
$DB_NAME = "your db name";
$ACCOUNT = "root";
$PASSWORD = "";
$STRIPE = "your stripe public api key";
$STRIPE_SECRET = "your stripe secret api key";
$AMOUNT = 1000; // = 10$

return [$DB_NAME,$ACCOUNT,$PASSWORD,$STRIPE,$STRIPE_SECRET,$AMOUNT,$CREATE_ACCOUNT_ON_DB];
?>
