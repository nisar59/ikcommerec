<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Mail;
use Booleanlogics\MultiCurrency\Model\CurrencyRate;
use DateTime;

class StringHelper extends SettingHelper {

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  string
     * @return string
     */
    private $domainId;

    public static function Slug($string, $type = '', $model, $vendor = null) {

        $string = str_slug($string, "-");
        $where = array('slug' => $string, 'status' => '');
        if ($type != '') {
            $count = $model::where('slug', 'like', '%' . $string . '%')
                    ->where('status', '!=', 'trash')
                    ->pluck('id')
                    ->toArray();
        } else {
            $count = $model::where('slug', 'like', '%' . $string . '%')->where('status', '!=', 'trash')->pluck('id')->toArray();
        }
        $count = count($count);
        if ($count == 0) {
            return $string;
        }
        $count = $count + 1;
        return $string = $string . '-' . $count;
        return $string;
    }

    public static function make_permalink($permalink, $model)
    {
        // convert the string to all lowercase
        $permalink = mb_strtolower($permalink, 'UTF-8');
        // strip out all whitespace
        $permalink_clean = str_replace(' ', '-', $permalink); //preg_replace('/\s*/', '', $permalink);
        $permalink_clean = preg_replace ('/[^\p{L}\p{N}]/u', '-', $permalink_clean);
        //$permalink_clean = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $permalink_clean);

        $slug = $maybe_slug = $permalink_clean;
        $next = 1;

        while ($model::where('slug', '=', $slug)->first()) {
            $slug = "{$maybe_slug}{$next}";
            $next++;
        }
        return $slug;
    }

    public static function slugify($string, $alternate = '-') {
        return $string = str_slug($string, $alternate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $string
     * @param  Boolean  $flag
     * @return string
     */
    public static function GenerateTitle($string, $flag = FALSE) {
        $string = ucfirst($string);
        if (!$flag) {
            $string = str_plural($string);
        }
        return $string;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $object
     * @return array
     */
    public static function AddDefaultOption($object, $defaultValue = 'Select') {
        $return = array(0 => $defaultValue);
        if (!empty($object)) {
            foreach ($object as $obj => $val) {
                $return[$obj] = $val;
            }
        }
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $object
     * @return array
     */
    public static function ObjectToArray($object) {
        $return = array();
        if (!empty($object)) {
            foreach ($object as $obj) {
                $return[] = $obj->category_id;
            }
        }
        return $return;
    }

    public static function getRenderHTML($string) {
        return html_entity_decode($string);
    }

    public static function getTargetURL($obj, $prepend = '') {
        if ($prepend != '') {
            $prepend = $prepend . '/';
        }
        return ($obj->url == '') ? URL::to('/' . $prepend . $obj->slug) : $obj->url;
    }

    public static function getRating($ratings) {
        $total = $ratings->count();
        if ($total > 0) {
            $sum = 0;
            foreach ($ratings as $rating) {
                $sum += $rating->rate;
            }
            $rating = round($sum / $ratings->count());
        } else {
            $rating = 0;
        }
        return view('front.snippets.rating-stars')->with(array('rating' => $rating, 'ratingData' => $ratings));
    }

    public static function timeElapsedString($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        //if (!$full)
        $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function sendMail($data) {
        $send = Mail::send(SettingHelper::getTheme() . 'emails.' . $data['template'], ['data' => $data], function ($message) use ($data) {
                    if (!empty($data['attachments'])) {
                        foreach ($data['attachments'] as $attachment) {
                            if ($attachment != '') {
                                $message->attach($attachment);
                            }
                        }
                    }
                    $setting = $data['data']['setting'];
                    $message->from($setting->getEmail(), $setting->getName());
                    $message->to($data['to'], $data['name'])->subject($data['subject']);
                });
        if (Mail::failures()) {
            return false;
        }
        return true;
    }

    public static function getLimitedText($string, $limit = 20) {
        return str_limit($string, $limit);
    }

    public static function validQueryString($string) {
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

    public static function validQueryNumber($string) {
        $string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        return $string;
    }

    public static function limitedText($string, $limit = 145) {
        $string = html_entity_decode($string);
        $string = strip_tags($string);
        $string = str_limit($string, $limit);
        return $string;
    }

    public static function stripTags($string) {
        $string = strip_tags($string);
        return $string;
    }

    public static function formatedDate($date, $formate = 'M d, Y') {

        $newDate = strtotime($date);
        return $newDate = date($formate, $newDate);
    }

    public static function maxInstallmentAmount($price) {
        $price = ($price * 95) / 100;
        return $price;
    }

    public static function formatMoney($number, $floatPlace = 2, $isAdd = false) {
        $price = number_format($number, $floatPlace);
        if ($isAdd) {
            $price = CurrencyRate::getPrefix() . ' ' . $price . CurrencyRate::getSufix();
        }
        return $price;
    }

    public static function getCompanyInfo($key) {
        return config('constants.' . $key);
    }

    public static function getMenu() {
        $pages = Post::Where('status', '=', 'publish')->where('type', '=', 'page')->where('show_in_menu', '=', 1)->get(array('id', 'title', 'slug'));
        return view('front.includes.main-menu')->with(array(
                    'pages' => $pages,
        ));
    }

    public static function getCurrentURI($segment = 1) {
        return Request::segment($segment);
//        $uri = explode('/', $_SERVER['REQUEST_URI']);
//        return end($uri);
    }

    public static function getAdminURI() {
        return parent::getAdmimURI();
    }

    public static function getMediaPath($type = 'thumb') {
        if ($type != 'thumb') {
            return parent::getUploadPath();
        }

        return parent::getThumbPath();
    }

    public static function getPostTypes() {
        $types = parent::getAllowTypes();
        $data = array();
        foreach ($types as $type) {
            $title = str_replace('-', ' ', ucfirst($type));
            $data[$type] = $title;
        }
        return $data;
    }

    public static function highlightKeywords($str, $find) {
        return $str;
        $searchtext = $str;
        $searchstrings = $find;
        $searchstrings = preg_replace('/\s+/', ' ', trim($searchstrings));
        $words = explode(' ', $searchstrings);
        $highlighted = array();
        foreach ($words as $word) {
            $highlighted[] = self::getRenderHTML("<font color='#00f'><b>" . $word . "</b></font>");
        }
        return strtr($searchtext, array_combine($words, $highlighted));
    }

    public static function getFirstWord($string, $index = 0) {
        $keywords = explode(' ', $string);
        return (isset($keywords[$index])) ? $keywords[$index] : null;
    }

    private static function getParameterFromYoutubeURL($url, $key = 'v') {
        if ($url != '') {
            $url = $url;
            parse_str(parse_url($url, PHP_URL_QUERY), $url_array_of_vars);
            return $url_array_of_vars[$key];
        }
        return false;
    }

    public static function getYoutubeVideoID($url) {
        return self::getParameterFromYoutubeURL($url);
    }

    public static function getYoutubeVideoThumb($url, $type = 'medium') {
        $thumbBaseURL = 'http://img.youtube.com/vi/' . self::getYoutubeVideoID($url) . '/';


        switch ($type) {
            case 'medium':
                return $thumbBaseURL . 'mqdefault.jpg';
                break;
            case 'high':
                return $thumbBaseURL . 'hqdefault.jpg';
                break;
            case 'standard':
                return $thumbBaseURL . 'sddefault.jpg';
                break;
            case 'maximum':
                return $thumbBaseURL . 'maxresdefault.jpg';
                break;
            default :
                return $thumbBaseURL . 'mqdefault.jpg';
                break;
        }
    }

    public static function arrayToStr($arr, $speator = ' ') {
        return collect($arr)->implode($speator);
    }

    public static function replaceStr($str, $search = 'uploads/', $replace = 'public/uploads/') {
        return str_replace($search, $replace, $str);
    }

    public static function getDiscountType($id, $type = 'coupon') {
        if ($type == 'coupon') {
            return CouponManager::getDiscountTypeById($id);
        }
        return PromotionManager::getDiscountTypeById($id);
    }

    public static function getDiscountFor($id, $type = 'coupon') {
        if ($type == 'coupon') {
            return CouponManager::getDiscountForById($id);
        }
        return PromotionManager::getDiscountForById($id);
    }

    public static function strToUpper($string) {
        return ucfirst($string);
    }

    public static function getCurrency() {
        return config('cart.currencySign');
    }

    public static function getVenderId() {
        return Session::get('domainId');
    }

    public static function getVenderFolderName() {
        return 'images';
        //return Session::get('uploadDir');
    }

}
