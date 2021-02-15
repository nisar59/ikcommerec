<?php

namespace Modules\CMS\Definitions;

class SectionType {

    const TYPE_1 = 1;
    const TYPE_2 = 2;
    const TYPE_3 = 3;
    const TYPE_4 = 4;
    const TYPE_5 = 5;
    const TYPE_6 = 6;
    const TYPE_7 = 7;
    const TYPE_8 = 8;
    const TYPE_9 = 9;
    const TYPE_10 = 10;
    const TYPE_11 = 11;
    const TYPE_12 = 12;
    const TYPE_13 = 13;
    const TYPE_14 = 14;
    const TYPE_15 = 15;


    private static $types = [
        self::TYPE_1 => 'Section (Title, Text, Image)',
        self::TYPE_2 => 'Process',
        self::TYPE_3 => 'Case Study',
        self::TYPE_4 => 'Query Form',
        self::TYPE_5 => 'Section (Icon, Title, Button Text, Button Link)',
        self::TYPE_6 => 'Section (Title, Text, Button Text, Button Link, Image)',
        self::TYPE_7 => 'Clients',
        self::TYPE_8 => 'Testimonials',
        self::TYPE_9 => 'Banner',
        self::TYPE_10 => 'Search Domain',
        self::TYPE_11 => 'Hosting Packages',
        self::TYPE_12 => 'Hosting Packages By Types',
        self::TYPE_13 => 'Plan Text ot HTML',
        self::TYPE_14 => 'Packages',
        self::TYPE_15 => 'Code',
    ];

    public static function getType($id = 1) {
        return (isset(self::$types[$id])) ? self::$types[$id] : null;
    }

    public static function getTypes() {
        return self::$types;
    }

    public static function getTypeIDByName($name) {
        return array_search($name, self::$types);
    }

}
