<?php

namespace App\Http\Helpers;

use App\Http\Helpers\StringHelper;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\Vendor;

class SettingHelper {

    /**
     * Show the form for editing the specified resource.
     *
     * @return Dir path
     */
    public static function getUploadDir() {
        return public_path() . '/uploads/';
    }

    public static function getImportDir() {
        return public_path() . '/uploads/' . StringHelper::getVenderFolderName() . '/import/';
    }

    public static function getExportDir() {
        return public_path() . '/uploads/' . StringHelper::getVenderFolderName() . '/export/';
    }

    public static function getReportDir() {
        return public_path() . '/uploads/' . StringHelper::getVenderFolderName() . '/reports/';
    }

    public static function getUploadPath() {
        return 'public/uploads/' . StringHelper::getVenderFolderName() . '/';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Dir path
     */
    public static function getThumbPath() {
        return 'public/uploads/' . StringHelper::getVenderFolderName() . '/thumbs/';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Admin Dir path
     */
    public static function getAdmimURI() {
        return env("BACK_OFFICE", 'backoffice') . '/';
    }
    public static function getStoreURI() {
        return env("WS_BASE_URL_FRONT") . '/';
    }

    public static function getWSBASEURL() {
        return env("WS_BASE_URL");
    }

    public static function getThemeDIR() {
        return 'themes.';
    }

    public static function getActiveTheme() {
        if (!Session::has('theme')) {
            return env("THEME");
        }
        return Session::get('theme');
    }

    public static function getTheme() {
        return self::getThemeDIR() . self::getActiveTheme() . '.';
    }

    public static function getThemeAssetsPath() {
        return self::getCdnUrl() . 'public/assets/store/';
    }

    public static function getCommonAssetsPath() {
        return self::getCdnUrl() . 'public/assets/common/';
    }

    public static function getThemeConifiguration() {
        $setting = resource_path('views/themes/' . self::getActiveTheme() . '/config/setting.php');
        if (\Illuminate\Support\Facades\File::exists($setting)) {
            require_once $setting;
            return THUMB_SIZES;
        }

        return false;
    }

    public static function getVendorFolderName($name) {
        $salt = substr(md5($name), 3, 8);
        return $name = substr(md5($name), 6, 12) . $name . $salt;
    }

    public static function getCdnUrl() {
        return asset('/');
        if (env("IS_LOCAL") == false) {
            return '//assets.' . self::getWSBASEURL() . '/';
        }
        $vendor = Vendor::getStoreName();
        // $url = (!$vendor) ? $vendor . '.' . self::getWSBASEURL() : self::getWSBASEURL() . '/';
        return '//' . $vendor . '.' . self::getWSBASEURL() . '/';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Admin Dir path
     */
    public static function getThumbSizes() {
        return array(
            'default' =>
            array(
                'width' => 55,
                'height' => 55
            ),
            '1' => array(
                'thumb-1' => array('width' => 81, 'height' => 116),
                'thumb-2' => array('width' => 480, 'height' => 690),
            ),
            'menu-item' => array(
                'thumb-1' => array('width' => 118, 'height' => 145)
            ),
            'slide' => array(
                'thumb-1' => array('width' => 1400, 'height' => 477)
            ),
            'page' => array(
                'thumb-1' => array('width' => 1400, 'height' => 360),
                'sub-page-banner' => array('width' => 1200, 'height' => 450)
            ),
            'cms' => array(
                'thumb-1' => array('width' => 1400, 'height' => 360),
                'sub-page-banner' => array('width' => 1200, 'height' => 450)
            ),
            'blog' => array(
                'thumb-1' => array('width' => 118, 'height' => 145),
                'banner' => array('width' => 1400, 'height' => 360),
                'card' => array('width' => 360, 'height' => 242),
                'list' => array('width' => 750, 'height' => 280),
                'thumbnail' => array('width' => 96, 'height' => 96),
            ),
            'blog-category' => array(
                'thumb-1' => array('width' => 118, 'height' => 145),
                'banner' => array('width' => 1400, 'height' => 360)
            ),
            'product-category' => array(
                'thumb-1' => array('width' => 160, 'height' => 107),
                'thumb-2' => array('width' => 445, 'height' => 315),
                'thumb-3' => array('width' => 850, 'height' => 300),
            ),
            'color' => array(
                'thumb-1' => array('width' => 33, 'height' => 33),
                'thumb-2' => array('width' => 160, 'height' => 215),
            ),
            'testimonial' => array(
                'thumb-1' => array('width' => 98, 'height' => 164),
                'large' => array('width' => 290, 'height' => 430),
            ),
            'product' => array(
                'thumb-1' => array('width' => 98, 'height' => 164),
                'thumb-2' => array('width' => 81, 'height' => 116),
                'thumb-3' => array('width' => 210, 'height' => 330),
                'thumb-4' => array('width' => 480, 'height' => 690),
                'thumb-5' => array('width' => 218, 'height' => 302),
                'compare' => array('width' => 540, 'height' => 300),
                'small' => array('width' => 50, 'height' => 50),
            ),
        );
    }

    public static function getPageTitleByType($typeSetting, $single = true) {
        if ($single) {
            return $typeSetting['data']['singular'];
        }
        return $typeSetting['data']['prular'];
    }

    protected static function getAllowTypes() {
        return array(
            'page',
            'cms',
            'blog',
            'icon',
            'slide',
            'vendor',
            'product',
                // 'setting',
                //'addvertise',
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  string
     * @return string
     */
    public static function getSetting($type) {
        $allowAppType = self::getAllowTypes();
        $settings = array(
            'page' => array(
                'title' => true,
                'slug' => true,
                'externalUrl' => false,
                'date' => false,
                'sort_order' => false,
                'isFeatured' => true,
                'isIframe' => true,
                'summery' => array('isView' => true, 'isEditor' => true),

                'content' => true,
                'categoryBox' => array(
                    'isView' => false,
                    'isMultiple' => false,
                    'data' => array('page')
                ),
                'parentBox' => true,
                'featuredImgBox' => array(
                    'isView' => true,
                    'isImg' => true,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'data' => array(
                    'type' => 'page',
                    'singular' => 'Page',
                    'prular' => 'Pages',
                ),
                'seoContent' => true,
                'multiAttributes' => true,
            ),
            'cms' => array(
                'title' => true,
                'slug' => true,
                'externalUrl' => false,
                'date' => false,
                'sort_order' => false,
                'isFeatured' => false,
                'isIframe' => false,
                'summery' => array('isView' => false, 'isEditor' => false),
                'content' => true,
                'categoryBox' => array(
                    'isView' => false,
                    'isMultiple' => false,
                    'data' => array('cms')
                ),
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => false,
                    'isImg' => false,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'data' => array(
                    'type' => 'cms',
                    'singular' => 'CMS',
                    'prular' => 'CMSs',
                ),
                'seoContent' => false,
                'multiAttributes' => false,
            ),
            'blog' => array(
                'title' => true,
                'slug' => true,
                'externalUrl' => false,
                'date' => false,
                'sort_order' => true,
                'isFeatured' => false,
                'summery' => array('isView' => true, 'isEditor' => true),
                'banner_image' => true,
                'banner_text' => true,
                'banner_description' => true,
                'featured_image' => true,
                'content' => true,
                'categoryBox' => array(
                    'isView' => true,
                    'isMultiple' => true,
                    'data' => array('blog')
                ),
                'tagsBox' => array(
                    'isView' => true,
                    'data' => array('blog')
                ),
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => true,
                    'isImg' => true,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'data' => array(
                    'type' => 'blog',
                    'singular' => 'blog',
                    'prular' => 'blogs',
                ),
                'seoContent' => true,
                'multiAttributes' => true,
                'category' => array(
                    'title' => true,
                    'title_urdu' => false,
                    'slug' => true,
                    'cto_title' => true,
                    'cto_button_text' => true,
                    'cto_short_description' => true,
                    'cto_url' => true,
                    'banner_text' => true,
                    'banner_description' => true,
                    'banner_image' => true,
                    'featured_image' => true,
                    'seoContent' => true,
                    'isFeatured' => true,
                    'isTopFeatured' => true,
                    'parentBox' => true,
                    'summery' => array('isView' => true, 'isEditor' => true),
                    'featuredImgBox' => array(
                        'isView' => true,
                        'isImg' => true,
                        'heading' => 'Featured Image',
                        'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                    ),
                )
            ),
            'icon' => array(
                'title' => true,
                'slug' => false,
                'externalUrl' => false,
                'date' => false,
                'sort_order' => true,
                'isFeatured' => true,
                'summery' => array('isView' => true, 'isEditor' => false),
                'content' => false,
                'categoryBox' => array(
                    'isView' => false,
                    'isMultiple' => false,
                    'data' => array('icon')
                ),
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => true,
                    'isImg' => true,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'data' => array(
                    'type' => 'icon',
                    'singular' => 'Icon',
                    'prular' => 'Icons',
                ),
                'seoContent' => false,
            ),
            'slide' => array(
                'title' => true,
                'slug' => false,
                'externalUrl' => true,
                'date' => false,
                'sort_order' => true,
                'isFeatured' => false,
                'summery' => array('isView' => true, 'isEditor' => false),
                'content' => false,
                'categoryBox' => array(
                    'isView' => false,
                    'isMultiple' => false,
                    'data' => array('slide')
                ),
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => true,
                    'isImg' => true,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'data' => array(
                    'type' => 'slide',
                    'singular' => 'Slide',
                    'prular' => 'Slides',
                ),
                'seoContent' => false
            ),
            'vendor' => array(
                'skucode' => false,
                'title' => false,
                'title_urdu' => false,
                'slug' => false,
                'externalUrl' => false,
                'sort_order' => false,
                'isFeatured' => false,
                'summery' => array('isView' => false, 'isEditor' => false),
                'content' => false,
                'content_urdu' => false,
                'price' => false,
                'price_1' => false,
                'price_2' => false,
                'installment' => false,
                'categoryBox' => array(
                    'isView' => false,
                    'isMultiple' => false,
                    'data' => array('vendor')
                ),
                'brandBox' => false,
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => false,
                    'isImg' => false,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'multiImage' => false,
                'multiAttributes' => false,
                'otherOption' => false,
                'data' => array(
                    'type' => 'vendor',
                    'singular' => 'Vendor',
                    'prular' => 'Vendors',
                ),
                'seoContent' => true,
                'category' => array(
                    'title' => true,
                    'title_urdu' => false,
                    'slug' => true,
                    'seoContent' => true,
                    'isFeatured' => true,
                    'isTopFeatured' => true,
                    'parentBox' => true,
                    'summery' => array('isView' => true, 'isEditor' => true),
                    'featuredImgBox' => array(
                        'isView' => true,
                        'isImg' => true,
                        'heading' => 'Featured Image',
                        'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                    ),
                )
            ),
            'product' => array(
                'skucode' => false,
                'title' => false,
                'title_urdu' => false,
                'slug' => false,
                'externalUrl' => false,
                'sort_order' => false,
                'isFeatured' => false,
                'summery' => array('isView' => false, 'isEditor' => false),
                'content' => false,
                'content_urdu' => false,
                'price' => false,
                'price_1' => false,
                'price_2' => false,
                'installment' => false,
                'categoryBox' => array(
                    'isView' => true,
                    'isMultiple' => true,
                    'data' => array('Product')
                ),
                'brandBox' => false,
                'parentBox' => false,
                'featuredImgBox' => array(
                    'isView' => false,
                    'isImg' => false,
                    'heading' => 'Featured Image',
                    'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                ),
                'multiImage' => false,
                'multiAttributes' => false,
                'otherOption' => false,
                'data' => array(
                    'type' => 'product',
                    'singular' => 'Product',
                    'prular' => 'Products',
                ),
                'seoContent' => true,
                'category' => array(
                    'title' => true,
                    'title_urdu' => false,
                    'slug' => true,
                    'seoContent' => true,
                    'isFeatured' => true,
                    'isTopFeatured' => true,
                    'parentBox' => true,
                    'summery' => array('isView' => true, 'isEditor' => true),
                    'featuredImgBox' => array(
                        'isView' => true,
                        'isImg' => true,
                        'heading' => 'Featured Image',
                        'extensionAllow' => array('jpg', 'jpeg', 'png', 'gif')
                    ),
                )
            ),
        );
        if (in_array($type, $allowAppType)) {
            return isset($settings[$type]) ? $settings[$type] : false;
        } else {
            return false;
        }
    }

}
