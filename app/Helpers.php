<?php

function getPrice($priceDecimal) {
    $price = $priceDecimal / 100;
    return number_format($price, 2, ',', ' ') . ' €';
}

function getSubTotalCoupon() {
    return Cart::subTotal() - request()->session()->get('coupon')['remise'];
}

function getTaxCoupon() {
    return (Cart::subTotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100);
}

function getTotalCoupon() {
    return Cart::subTotal() - request()->session()->get('coupon')['remise'] + (Cart::subTotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100);
}
