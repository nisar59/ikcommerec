<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon;
use App\Model\Status;
use App\Models\ProductStatus as ProductStatusModel;

class ProductStatus {

    protected $prefix;

    public function __construct() {
        $this->prefix = DB::getTablePrefix();
    }

    public static function getProductStatus() {
        $data = ProductStatusModel::where('status', Status::STATUS_ACTIVE)->pluck('name', 'id');
        return collect([null => 'Please Select'] + $data->all());
    }

    public function getActiveProductStatus($status = Status::STATUS_ACTIVE) {
        return ProductStatusModel::where('status', $status)->get();
    }
}
