<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon;
use App\Model\Status;
use App\Models\Category;

class CategoryRepository {

    protected $prefix;

    public function __construct() {
        $this->prefix = DB::getTablePrefix();
    }

    public static function getCategories($type = 'product') {
        $data[null] = 'Please Select';
        $data = Category::where('status', Status::STATUS_ACTIVE)->where('type', $type)->pluck('title', 'id');
        return $data;
    }

    public static function getActiveCategories($type = 'blog', $featured = false, $limit = 5) {
        $categories = Category::with('uri')->where('status', Status::STATUS_ACTIVE)->where('type', $type);
        if($featured){
            $categories->where('is_featured', 1)->orderBy('sort_order', 'ASC');
        }
        return $categories->limit($limit)->get();
    }

}
