<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $guarded = [];

    // shop title
    public static function site_title() {
        return Settings::select('company_name')->value('company_name');
    }
    
    // // shop fav icon
    public static function shop_fav() {
        $shop_fav = Settings::select('fav_icon')->first();
        return $shop_fav; 
    }
    // // shop logo
    public static function shop_logo() {
        $shop_logo = Settings::select('logo')->first();
        return $shop_logo; 
    }
    // shop email
    public static function shop_email() {
        $shop_email = Settings::select('email1')->first();
        return $shop_email; 
    }
    // shop address
    public static function shop_address() {
        return Settings::select('address')->value('address');
    }
    //call 1
    public static function call_1() {
        $call_1 = Settings::select('phone1')->first();
        return $call_1; 
    }
    //city
    public static function city() {
        return Settings::select('city', 'zip')->value('city', 'zip');
    }
    
}
