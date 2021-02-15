<?php

namespace App\Imports;


use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Products\Entities\Products;
use Modules\WareHouses\Entities\WareHouses;
use Modules\Suppliers\Entities\Suppliers;
use Modules\Category\Entities\Category;
use Modules\CMS\Entities\Permalink;
use Modules\Brands\Entities\Brands;
use Modules\Products\Entities\ProductsWarehouseStocks;
use Modules\Products\Entities\ProductImages;
use Modules\Stores\Entities\Stores;
use App\Http\Helpers\StringHelper;
use App\Http\Helpers\SettingHelper;
use Illuminate\Support\Facades\File;
use App\Http\Helpers\MediaHelper;
use Auth, DB;

class ProductsImport implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow {

    private $model;
    public function __construct() {
       //dd('sdfsdfds');
        $this->model = 'Product()';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    /* Array
  (
  [0] => sku
  [1] => Title
  [2] => short description
  [3] => description
  [4] => weight
  [5] => Supplier
  [6] => brand
  [7] => stock status -> 1 / 0
  [8] => featured -> 1 / 0
  [9] => enable reviews -> 1 / 0
  [10] => categoreis seprated by commma
  [11] => pusrcahse price
  [12] => price
  [13] => sale_price
  [14] => images   seprated by comma
  [15] => status  -> 1 / 0
  [16] => Stocks     qty-warehouse-store
    [17] => meta title
    [18] => meta desc
    [19] => meta keywords

  ) */


    public function model(array $row) {
        $currentUser = Auth::user();

        $currentUser = $currentUser->id;

        $product = new Products();
        $existing = $this->isProductExist(trim($row[0]));
        if ($existing) {
            $product = $existing;
        }

        $product->user_id = $currentUser;
        $product->sku = trim($row[0]);
        $product->name = is_null($row[1]) ? $product->name : $row[1];


        $product->short_description = is_null($row[2]) ? $product->short_description : $row[2];
        $product->description = is_null($row[3]) ? $product->long_description : $row[3];
        $product->weight = is_null($row[4]) ? $product->long_description : $row[4];
        $product->supplier_id = is_null($row[5]) ? $product->supplier_id : $this->findorCreate(new Suppliers(), $row[5], 'name');
        $product->brand_id = is_null($row[6]) ? $product->brand_id : $this->findorCreatebr(new Brands(), $row[6], 'name');
        $product->stock_status = $product->stock_status = is_null($row[7]) ? $product->stock_status : $row[7];

        $product->featured = $product->featured = is_null($row[8]) ? $product->featured : $row[8];
        $product->enable_reviews = $product->enable_reviews = is_null($row[9]) ? $product->enable_reviews : $row[9];
        $product->purchase_price = $product->purchase_price = is_null($row[11]) ? $product->purchase_price : $row[11];
        $product->price = $product->price = is_null($row[12]) ? $product->price : $row[12];
        $product->sale_price = $product->sale_price = is_null($row[13]) ? $product->sale_price : $row[13];
        $product->status = $product->status = is_null($row[15]) ? $product->status : $row[15];
        $product->meta_title = is_null($row[17]) ? $product->meta_title : $row[17];
        $product->meta_keywords = is_null($row[19]) ? $product->meta_keywords : $row[19];
        $product->meta_description = is_null($row[18]) ? $product->meta_description : $row[18];
        $product->slug = is_null($row[1]) ? $product->slug : $row[1];



        if($existing){
            $product->save();
            if(!is_null($row[4])){
                $product->categories()->sync($this->findOrCreateCategory($product->id, $row[10]));
            }
            /*$product->colors()->sync($this->colors($row[19]));
            $product->basedColors()->sync($this->colors($row[20]));*/
            //$this->slug($row[1], $product->id);
            if(isset($row[14]) && !is_null($row[14])){
                $this->images($product->id, trim($row[14]));
            }
            if(isset($row[16]) && !is_null($row[16])){
                $this->stocksMangement($product->id, trim($row[16]));
            }

        }else{
            $product->save();

            $product->categories()->attach($this->findOrCreateCategory($product->id, $row[10]));
            /*$product->colors()->attach($this->colors($row[19]));
            $product->basedColors()->attach($this->colors($row[20]));*/
            $this->slug($row[1], $product->id);
            if(isset($row[14])){
                $this->images($product->id, trim($row[14]));
            }
            if(isset($row[16]) && !is_null($row[16])){
                $this->stocksMangement($product->id, trim($row[16]));
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
                ProductImages::where('p_id', $id)->delete();
                foreach ($array as $key => $image) {
                    $image = explode('/', $image);
                    $image = end($image);
                    $image = trim($image);
                    $productImage = new ProductImages();
                    $productImage->p_id = $id;
                    $productImage->images = $image;
                    $productImage->sort_order = MaxSortorder('product_images');
                    $productImage->save();
                }
            }
        }
    }




    private function slug($string, $id) {
        $cms=Products::find($id);
        $permalink = $this->make_permalink($string, 'permalinks');
        $uri = Permalink::firstOrCreate(['model' => 'PRODUCT', 'reference' => $id]);
        $uri->slug = strtolower(str_replace(' ', '-', $permalink));
        $cms->slug = $uri->slug;
        $cms->save();
        return $uri->save();
        // return URLRepository::URL($this->model, $permalink, $id);
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

    private function findorCreatebr($model, $name, $column = 'name') {
        if(is_null($name)){
            return null;
        }
        $record = $model::where($column, ucwords(trim($name)))->first();

        if ($record) {
            return $record->id;
        }
        $model->{$column} = $name;
        $model->status = 1;
        $model->slug = $this->make_permalink($name, 'permalinks');
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
               // $catename = $this->explodeString($category, '/');
                $categoryName = trim($category);
                $record = Category::where('name', ucfirst($categoryName))->first();
                if ($record) {
                    array_push($ids, $record->id);
                    continue;
                }

                if ($categoryName !== '') {
                    $cat = new Category();
                    $cat->name = ucfirst($categoryName);
                  //  $cat->type = "product";
                    $cat->slug = $this->make_permalink( $cat->name, 'permalinks');//StringHelper::Slug($categoryName, 'product', new Category());
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
    public function stocksMangement($product_id,$values){
//dd($values);
        if(isset($values)){
            $cms=Products::find($product_id);
            $categories = $this->explodeString($values);

            $qty =0;
            if (!empty($categories)) {
                ProductsWarehouseStocks::where('p_id',$product_id)->delete();
                foreach ($categories as $category) {
                    $catename = $this->explodeString($category, '-');
                    $qty=$qty+$catename[0];
                    ProductsWarehouseStocks::create([
                        'p_id'=>$product_id,
                        'ware_house_id'=>$this->findorCreate(new WareHouses(), $catename[1], 'name'),
                        'quantity'=>$catename[0],
                        'available_quantity'=>$catename[0],
                        'store_id'=>$this->findorCreate(new Stores(), $catename[2], 'name'),
                    ]);
                }
            }



            $cms->quantity= $qty;
            $cms->save();
        }
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
        return Products::where(['sku' => trim($sku)])->first();
    }

}

