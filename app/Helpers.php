<?php

function getPrice($priceDecimal) {
    $price = $priceDecimal / 100;
    return number_format($price, 2, ',', ' ') . ' €';
}

