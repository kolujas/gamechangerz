<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
         * * Table name.
         * @var string
         */
        protected $table = 'coupons';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_coupon';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
             'name', 'slug'
        ];
}
