<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function discount($subTotal)
    {
        return $subTotal * ( $this->percent_off / 100 );
    }

}
