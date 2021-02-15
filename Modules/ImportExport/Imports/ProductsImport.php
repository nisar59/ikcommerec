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
use Auth, DB;

class ProductsImport implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow {

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
        $currentUser = Auth::user();
        $currentUser = $currentUser->id;

        $product = new Product();
        $existing = $this->isProductExist(trim($row[0]));
        if ($existing) {
            $product = $existing;
        }

        $featureImage = trim($row[6]);
        $image = null;
        if ($featureImage !== '') { // Upload Images
            $image = explode('/', $featureImage);
            $image = end($image);
            $image = trim($image);
        }

        $product->image = is_null($row[6]) ? $product->image : $image;
        $product->user_id = $currentUser;
        $product->vendor_id = is_null($row[39]) ? $product->vendor_id : $this->findorCreate(new Vendor(), $row[39], 'company_name');

        $product->dyes_id = is_null($row[28]) ? $product->dyes_id : $this->findorCreate(new Dye(), $row[28]);
        $product->design_id = is_null($row[17]) ? $product->design_id : $this->findorCreate(new Design(), $row[17]);
        $product->collection_id = is_null($row[18]) ? $product->collection_id : $this->findorCreate(new Collection(), $row[18]);
        $product->weave_id = is_null($row[36]) ? $product->weave_id : $this->findorCreate(new Weave(), $row[36]);
        $product->knot_id = is_null($row[36]) ? $product->knot_id : $this->findorCreate(new Knot(), $row[36]);
        $product->style_id = $this->findorCreate(new Style(), ucfirst('Casual')); //Currently not in csv file, but we set hardcoded as Casual
        $product->type_id = $this->findorCreate(new Type(), ucfirst('Wool')); //Currently not in csv file, but we set hardcoded as Wool
        $product->pile_height_id = $this->findorCreate(new PileHeight(), ucfirst('15 - 18 mm')); //Currently not in csv file, but we set hardcoded as '15 - 18 mm'
        $product->shape_id = is_null($row[34]) ? $product->shape_id : $this->findorCreate(new Shape(), $row[34]);
        $product->base_color_id = is_null($row[22]) ? $product->base_color_id : $this->findorCreate(new BaseColor(), $row[22]);
        $product->color_id = is_null($row[21]) ? $product->color_id : $this->findorCreateWithParent(new Color(), $row[21], 'name', $product->base_color_id, 'base_color');
        $product->border_color_id = $product->color_id; //Currently not in csv file, but we set hardcoded as color
        $product->age_id = is_null($row[31]) ? $product->age_id : $this->findorCreate(new Age(), $row[31]);
        $product->condition_id = is_null($row[32]) ? $product->condition_id : $this->findorCreate(new Condition(), $row[32]);
        $product->material_id = is_null($row[30]) ? $product->material_id : $this->findorCreate(new Material(), $row[30]);
        $product->pile_id = is_null($row[29]) ? $product->pile_id : $this->findorCreate(new Pile(), $row[29]);
        $product->pattern_id = is_null($row[27]) ? $product->pattern_id : $this->findorCreate(new Pattern(), $row[27]);
        $product->product_type_id = is_null($row[12]) ? $product->product_type_id : $this->findorCreate(new ProductType(), ucfirst($row[12]));
        $product->product_status_id = is_null($row[55]) ? $product->product_status_id : ((int)$row[55] == 1 ? 1 : 2); //1 is active and 2 for hidden
        $product->cost_unit_id = $this->findorCreate(new CostUnit(), ucfirst('Item')); //Currently its not available in csv but we set it cost unit as Item

        $product->sku = trim($row[0]);
        $product->quantity = is_null($row[5]) ? $product->quantity : $row[5];
        $product->title = is_null($row[1]) ? $product->title : $row[1];
        //$product->slug = $this->slug($row[1]);
        $product->short_description = is_null($row[3]) ? $product->short_description : $row[3];
        $product->long_description = is_null($row[2]) ? $product->long_description : $row[2];

        $product->weight = is_null($row[41]) ? $product->weight : $row[41];
        $product->cost = is_null($row[44]) ? $product->cost : $row[44];
        $product->cost_per_sqm = is_null($row[45]) ? $product->cost_per_sqm : $row[45];
        $product->sale_per_sqm = is_null($row[46]) ? $product->sale_per_sqm : $row[46];
        $product->sqm = is_null($row[47]) ? $product->sqm : $row[47];
        $product->sale_price = is_null($row[42]) ? $product->sale_price : $row[42];
        $product->discounted_price = is_null($row[43]) ? $product->discounted_price : $row[43];
        $product->country_of_manufacture = is_null($row[37]) ? $product->country_of_manufacture : $row[37];

        $product->meta_title = is_null($row[48]) ? $product->meta_title : $row[48];
        $product->meta_keywords = is_null($row[49]) ? $product->meta_keywords : $row[49];
        $product->meta_description = is_null($row[50]) ? $product->meta_description : $row[50];

        $product->batch = is_null($row[38]) ? $product->batch : $row[38];
        $product->actual_size = is_null($row[23]) ? $product->actual_size : $row[23];
        $product->rounded_size = is_null($row[24]) ? $product->rounded_size : $row[24];
        $product->size_id = is_null($row[25]) ? $product->size_id : $this->findorCreate(new Size(), $row[25]);
        $product->size_range = is_null($row[26]) ? $product->size_range : $row[26];
        $product->kpsi = is_null($row[33]) ? $product->kpsi : $row[33];
        $product->rug_type = is_null($row[35]) ? $product->rug_type : $row[35];
        $product->supplier_sku = is_null($row[40]) ? $product->supplier_sku : $row[40];

        if($existing){
            $product->save();
            if(!is_null($row[4])){
                $product->categories()->sync($this->findOrCreateCategory($product->id, $row[4]));
            }
            /*$product->colors()->sync($this->colors($row[19]));
            $product->basedColors()->sync($this->colors($row[20]));*/
            //$this->slug($row[1], $product->id);
            if(isset($row[61]) && !is_null($row[61])){
                $this->images($product->id, trim($row[61]));
            }
        }else{
            $product->save();

            $product->categories()->attach($this->findOrCreateCategory($product->id, $row[4]));
            /*$product->colors()->attach($this->colors($row[19]));
            $product->basedColors()->attach($this->colors($row[20]));*/
            $this->slug($row[1], $product->id);
            if(isset($row[61])){
                $this->images($product->id, trim($row[61]));
            }
        }
    }

    public function batchSize(): int {
        return 1000;
    }

    public function chunkSize(): int {
        return 15;
    }

    public function startRow(): int {
        return 2;
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