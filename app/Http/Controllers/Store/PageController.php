<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/29/2019
 * Time: 5:06 PM
 */

namespace App\Http\Controllers\Store;


use App\Definitions\Template;
use Modules\CMS\Entities\Cms;
use Modules\CMS\Entities\Permalink;
use Modules\CMS\Entities\Silder;
use Modules\CMS\Entities\CmsSection;
use Modules\CMS\Entities\PageSection;
use Modules\CMS\Entities\CmsBlock;
use Modules\CMS\Definitions\SectionType;
use Modules\Brands\Entities\Brands;
use Modules\Slides\Entities\Sliders;
use Modules\Category\Entities\Category;
use Modules\Products\Entities\Products;
use Illuminate\Http\Request;
use DarthSoup\Whmcs\Facades\Whmcs;
use Config;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;

class PageController
{
    public function __construct()
    {
       // parent::__construct();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->data['manu_categories'] = Category:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->settings();
    }

    public function home(){
         //dd('dd');
        $this->data['page'] = Cms::where('template_id', Template::TEMPLATE_5)->where('status', 1)->first();
        $this->data['sections'] = $this->data['page'] ? $this->data['page']->sections()->where('status', 1)->orderBy('sort_order', 'ASC')->get() : null;
        /*if ($this->data['page']->template_id == Template::TEMPLATE_5){
            $this->data['clients'] = Client::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
        }*/
        //$this->data['products'] = Whmcs::GetProducts(['pid' => '136,125,126']);
        //$this->data['products'] = Whmcs::GetTLDPricing(['currencyid' => 3]);
        //dd($this->data['products']);
        //dd($this->data);
        return view('store.index')->withData($this->data);
    }

    public function index(Request $request,$id){
        if($id){
            $this->data['page'] = Cms::where('id', $id)->where('status', 1)->first();
            $this->data['sections'] = $this->data['page'] ? $this->data['page']->sections()->where('status', 1)->orderBy('sort_order', 'ASC')->get() : null;
            if ($this->data['page']->template_id == Template::TEMPLATE_5){
                $this->data['clients'] = Client::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
            }
            if ($this->data['page']->template_id == Template::TEMPLATE_5){
                $this->data['clients'] = Client::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
            }
            return view('store.index')->withData($this->data);
        }
    }

    public function detail(Request $request,$id){
      // dd($id);
        if($id){

            $this->data['page'] = Cms::where('id', $id)->where('status', 1)->first();
            $this->data['sections'] = $this->data['page'] ? $this->data['page']->sections()->where('status', 1)->orderBy('sort_order', 'ASC')->get() : null;

//dd(  $this->data['page'] );
            if($this->data['page']->id==12){
                return view('store.about')->withData($this->data);
            }
            if($this->data['page']->id==38){
                return view('store.faq')->withData($this->data);
            }
            if($this->data['page']->id==9){
                return view('store.contact')->withData($this->data);
            }
        }

//            if ($this->data['page']->template_id == Template::TEMPLATE_5){
//                $this->data['clients'] = Client::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
//                $this->data['blogs'] = Blog::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->limit(3)->get();
//            } elseif ($this->data['page']->template_id == Template::TEMPLATE_4){
//                $this->data['case_studies'] = CaseStudy::where('status', 1)->orderBy('sort_order', 'ASC')->get();
//                $this->data['first_section'] = $this->data['sections']->first();
//                $this->data['sections'] = $this->data['sections']->slice(1)->take(100);
//            } elseif ($this->data['page']->template_id == Template::TEMPLATE_3){
//                $this->data['first_section'] = $this->data['sections']->first();
//               // $this->data['sections'] = $this->data['sections']->slice(1)->take(100);
//            } elseif ($this->data['page']->template_id == Template::TEMPLATE_2){
//                $this->data['first_section'] = $this->data['sections']->first();
//                //$this->data['sections'] = $this->data['sections']->slice(1)->take(100);
//            }
//            elseif ($this->data['page']->template_id == Template::TEMPLATE_9){
//                $this->data['faq'] = Faq::where('status', 1)->orderBy('sort_order', 'ASC')->get();
//                $this->data['faq_data'] = Faq::where('status', 1)->orderBy('sort_order' , 'ASC')->get();
//
//            }
//
//            if($this->data['page']->template_id == Template::TEMPLATE_9)
//            {
//                return view('store.faq')->withData($this->data);
//            }
//            else
//            {
//            return view('store.index')->withData($this->data);
//            }
//
//        }
    }

    public function faqcategory($id)
    {
      if($id)
      {
          $this->data['faq'] = Faq::where('status', 1)->orderBy('sort_order', 'ASC')->get();
          $this->data['faq_data'] = Faq::where('status', 1)->where('faq_category' , $id)->orderBy('sort_order' , 'ASC')->get();
          return view('store.faq')->withData($this->data);
      }  
      else
      {
        return redirect(url('/faq')); 
      }
    }

    public function caseStudy($id){
        if($id){
            $this->data['case_study'] = CaseStudy::where('id', $id)->where('status', 1)->first();
            return view('store.case_study')->withData($this->data);
        } else {
            return redirect(url('/'));
        }
    }

    public function front(Request $request){
        return view('store.index')->withData($this->data);
    }
    public function settings(){
        /*config setting*/
        $this->data['setting'] = SettingController::getSettings();
        foreach($this->data['setting'] as $key => $value) {
            Config::set('settings.'.$key, $value);
        }

        /**=== SMTP ===**/
        if(Config::get('settings.config_email_host')){
            Config::set('mail.host', Config::get('settings.config_email_host'));
        }
        if(Config::get('settings.config_email_port')){
            Config::set('mail.port', Config::get('settings.config_email_port'));
        }
        if(Config::get('settings.config_email_encryption_type')){
            Config::set('mail.encryption', Config::get('settings.config_email_encryption_type'));
        }
        if(Config::get('settings.config_email_username')){
            Config::set('mail.username', Config::get('settings.config_email_username'));
        }
        if(Config::get('settings.config_email_password')){
            Config::set('mail.password', Config::get('settings.config_email_password'));
        }
        if(Config::get('settings.config_email_from_address')){
            Config::set('mail.from.address', Config::get('settings.config_email_from_address'));
        }
        if(Config::get('settings.config_email_from_name')){
            Config::set('mail.from.name', Config::get('settings.config_email_from_name'));
        }
        /**=== PAYPAL ===**/
        if(Config::get('settings.config_paypal_client_id')){
            Config::set('paypal.client_id', Config::get('settings.config_paypal_client_id'));
        }
        if(Config::get('settings.config_paypal_secret')){
            Config::set('paypal.secret', Config::get('settings.config_paypal_secret'));
        }
        if(Config::get('settings.config_paypal_mode')){
            Config::set('paypal.settings.mode', Config::get('settings.config_paypal_mode'));
        }
    }
}