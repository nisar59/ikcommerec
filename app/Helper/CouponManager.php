<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Mail;
use DateTime;

class CouponManager extends SettingHelper {

    public static function getDiscountType() {
        return [1 => 'Fixed', 2 => '%'];
    }

    public static function getDiscountFor() {
        return [
            1 => 'Cart',
//            2 => 'Product',
//            3 => 'Brand'
        ];
    }

    public static function getCode($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . '-' . substr(md5(uniqid(rand(), true)), 3, 10);
    }

    public static function getDiscountTypeById($id) {
        $types = self::getDiscountType();
        if (isset($types[$id])) {
            return $types[$id];
        }
    }

    public static function getDiscountForById($id) {
        $types = self::getDiscountFor();
        if (isset($types[$id])) {
            return $types[$id];
        }
    }

}
