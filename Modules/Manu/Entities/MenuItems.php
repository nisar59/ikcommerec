<?php

namespace Modules\Manu\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = 'menu_items';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'url', 'type', 'target', 'status');

    public $timestamps = true;

    public function menu() {
        return $this->belongsTo('Modules\Manu\Entities\Menu', 'menu_id', 'id');
    }

    public function childs() {
        return $this->hasMany('Modules\Manu\Entities\MenuItem', 'parent_id', 'id');
    }

    public function category() {
        return $this->hasOne('Modules\Category\Entities\Category', 'id', 'category_id');
    }

    public function client_category() {
        return $this->hasOne('App\Models\CCategory', 'id', 'cc_id');
    }

    public function page() {
        return $this->hasOne('Modules\CMS\Entities\Cms', 'id', 'cms_id');
    }

    public function getAction() {
        $type = $this->type;
        if ($type == 'blog_category' || $type == 'product_category') {
            if($this->category && $this->category->permalink && $this->category->permalink->slug){
                return $type == 'blog_category' ? route('store-blog-slug', $this->category->permalink->slug) : route('store-url', $this->category->permalink->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'page') {
            if($this->post && $this->post->uri && $this->post->uri->slug){
                return url($this->post->uri->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'size') {
            if($this->size && $this->size->uri && $this->size->uri->slug){
                return url($this->size->uri->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'color') {
            if($this->color && $this->color->uri && $this->color->uri->slug){
                return url($this->color->uri->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'style') {
            if($this->style && $this->style->uri && $this->style->uri->slug){
                return url($this->style->uri->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'shape') {
            if($this->shape && $this->shape->uri && $this->shape->uri->slug){
                return url($this->shape->uri->slug);
            }else{
                return '#';
            }
        } elseif ($type == 'material') {
            if($this->material && $this->material->uri && $this->material->uri->slug){
                return url($this->material->uri->slug);
            }else{
                return '#';
            }
        } else {
            if (strpos($this->url, "http://") !== false || strpos($this->url, "https://") !== false){
                return $this->url;
            }
            else {
                return route('store-index').'/'.$this->url;
            }
            //return $this->url;
        }
    }
}
