<?php

namespace App\Imports;

use App\Models\BaseColor;
use App\Models\CostUnit;
use App\Models\Knot;
use App\Models\Material;
use App\Models\Pile;
use App\Models\PileHeight;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\Size;
use App\Models\Type;
use App\Models\Vendor;
use App\Models\WarehouseProductStock;
use App\Repositories\URLRepository;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Color;
use App\Models\Design;
use App\Models\Collection;
use App\Models\Condition;
use App\Models\Shape;
use App\Models\Dye;
use App\Models\Style;
use App\Models\Pattern;
use App\Models\Weave;
use App\Http\Helpers\StringHelper;
use App\Http\Helpers\SettingHelper;
use App\Models\Category;
use App\Models\Age;
use Illuminate\Support\Facades\File;
use App\Models\Media;
use App\Http\Helpers\MediaHelper;
use App\Models\URL;
use Auth, DB;

class ProductsImportsDelete implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow {

    private $model;
    public function __construct() {
        $this->model = 'Product()';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row) {
        //dd($row[0]);

        $currentUser = Auth::user();
        $currentUser = $currentUser->id;
        //dd('asd');
        $product = new Product();
        $existing = $this->isProductExist(trim($row[0]));
        if ($existing) {
            $product = $existing;
          $delPro=$this->deleteproducts($product->sku);
        }



    }

    public function batchSize(): int {
        return 1000;
    }

    public function chunkSize(): int {
        return 15;
    }

    public function startRow(): int {
        return 1;
    }

    public function images($id, $images){

        if($images){
            $array = explode(',', $images);
            if (!empty($array)) {
                ProductImage::where('product_id', $id)->delete();
                foreach ($array as $key => $image) {
                    $image = explode('/', $image);
                    $image = end($image);
                    $image = trim($image);
                    $productImage = new ProductImage();
                    $productImage->product_id = $id;
                    $productImage->image = $image;
                    $productImage->save();
                }
            }
        }
    }

    private function slug($string, $id) {
        $permalink = $this->make_permalink($string, 'u_r_ls');
        return URLRepository::URL($this->model, $permalink, $id);
    }

    private function make_permalink($permalink, $table)
    {
        // convert the string to all lowercase
        $permalink = mb_strtolower($permalink, 'UTF-8');
        $permalink = str_replace(' ', '-', $permalink);
        $permalink_clean = preg_replace ('/[^\p{L}\p{N}]/u', '-', $permalink);
        $permalink_clean = preg_replace('/-+/', '-', $permalink_clean);

        $slug = $maybe_slug = $permalink_clean;
        $next = 1;

        while (DB::table($table)->where('slug', '=', $slug)->first()) {
            $slug = "{$maybe_slug}{$next}";
            $next++;
        }

        return $slug;
    }

    private function findorCreate($model, $name, $column = 'name') {
        if(is_null($name)){
            return null;
        }
        $record = $model::where($column, ucwords(trim($name)))->first();

        if ($record) {
            return $record->id;
        }
        $model->{$column} = $name;
        $model->status = 1;
        $model->save();
        return $model->id;
    }

    private function findorCreateWithParent($model, $name, $column = 'name', $parent_id, $column_name) {
        if(is_null($name) || is_null($parent_id)){
            return null;
        }
        $record = $model::where($column, ucwords(trim($name)))->where($column_name, $parent_id)->first();

        if ($record) {
            return $record->id;
        }
        $model->{$column} = $name;
        $model->{$column_name} = $parent_id;
        $model->status = 1;
        $model->save();
        return $model->id;
    }

    private function findOrCreateCategory($product_id, $name) {
        $ids = [];
        $categories = $this->explodeString($name);
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $catename = $this->explodeString($category, '/');
                $categoryName = trim(end($catename));
                $record = Category::where('title', ucfirst($categoryName))->first();
                if ($record) {
                    array_push($ids, $record->id);
                    continue;
                }

                if ($categoryName !== '') {
                    $cat = new Category();
                    $cat->title = ucfirst($categoryName);
                    $cat->type = "product";
                    $cat->slug = StringHelper::Slug($categoryName, 'product', new Category());
                    $cat->status = 1;
                    $cat->save();
                    if ($cat) {
                        array_push($ids, $cat->id);
                    }
                }
            }
        }

        return $ids;
    }

    private function colors($name) {
        $ids = [];
        $colors = $this->explodeString($name, '/');
        if (!empty($colors)) {
            foreach ($colors as $color) {
                $color = trim($color);
                $record = Color::where('name', $color)->first();
                if ($record) {
                    array_push($ids, $record->id);
                    continue;
                }
                if ($color !== '') {
                    $col = new Color();
                    $col->name = $color;
                    $col->slug = StringHelper::Slug($color, '', new Color());
                    $col->status = 1;
                    $col->save();
                    if ($col) {
                        array_push($ids, $col->id);
                    }
                }
            }
        }
        return $ids;
    }

    private function explodeString($string, $disclimter = ',') {
        return explode($disclimter, $string);
    }

    private function isProductExist($sku) {
        return Product::where(['sku' => trim($sku)])->first();
    }
    private function deleteproducts($sku) {
        $product = Product::where('sku', $sku)->first();
        if ($product->delete()) {
            URL::where('model', 'Product()')->where('reference', $product->id)->delete();

        }
        return true;
    }

}

/* Array
  (
  [0] => sku
  [1] => name
  [2] => description
  [3] => short_description
  [4] => categories
  [5] => qty
  [6] => image
  [7] => image_label
  [8] => small_image
  [9] => small_image_label
  [10] => thumbnail
  [11] => thumbnail_label
  [12] => product_type
  [13] => attribute_set_code
  [14] => tax_class_name
  [15] => product_online
  [16] => visibility
  [17] => design
  [18] => custom_collection
  [19] => color
  [20] => base_color
  [21] => newcolor
  [22] => color_family
  [23] => actual_size
  [24] => rounded_size
  [25] => base_size
  [26] => size_range
  [27] => pattern
  [28] => dyes
  [29] => pile
  [30] => foundation
  [31] => age
  [32] => condition
  [33] => kpsi
  [34] => shape
  [35] => rug_type
  [36] => weave
  [37] => country_of_manufacture
  [38] => batch
  [39] => manufacturer
  [40] => supplier_sku
  [41] => weight
  [42] => price
  [43] => special_price
  [44] => cost
  [45] => costsqm
  [46] => pricepersqm
  [47] => sqm
  [48] => meta_title
  [49] => meta_keyword
  [50] => meta_description
  [51] => custom_design
  [52] => page_layout
  [53] => manage_stock
  [54] => stock_availability
  [55] => is_in_stock
  [56] => supplier_design_code
  [57] => news_from_date
  [58] => news_to_date
  [59] => product_websites
  [60] => website_id
  ) */