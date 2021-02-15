<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\FlashMessage;
use App\Http\Helpers\MediaHelper;
use App\Model\Status;

class BaseModel extends Model {

    protected $rules = array();
    protected $errors;
    protected $validator;

    public function getCreatedAt() {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    public function getStatus($isOrignal = true) {
        if ($isOrignal) {
            return $this->status;
        }
        return Status::getStatus($this->status);
    }

    public function validate($data) {
        return $this->validator = Validator::make($data, $this->rules, $this->messages = [], $this->attributes = []);
    }

    public function fails() {
        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors();
            return true;
        }
        return false;
    }

    public function errors() {
        return FlashMessage::getValidationMessages($this->errors->getMessages());
    }

    public function JsonErrors() {
        return $errors = $this->validator->getMessageBag()->toArray();

//        if ($errors) {
//            foreach ($errors as $error) {
//                return 'asdfasdfas';
//            }
//        }
    }

    public function getFeaturedImage($type = 'product', $thumb = 'thumb-1', $directory = null) {
        if (($this->media_id != 0 || $this->media_id != '' || $this->media_id != 0) && $this->media) {
            return MediaHelper::getThumbImage($this->media->path, $type, $thumb, $directory);
        }
        return MediaHelper::getPlaceHolder($type, $thumb);
    }

    public function getOrderNum() {
        $srv = "";
        if (isset($_SERVER['SERVER_ADDR'])) {
            $srv = $_SERVER['SERVER_ADDR'];
        }

        $charid = md5(uniqid(rand() . $srv . time(), true));
        $hyphen = ""; //chr(45); // "-"
        $uuid = substr($charid, 0, 4) . $hyphen
                . substr($charid, 4, 8) . $hyphen;
        //. substr($charid, 12, 8) . $hyphen
        // . substr($charid, 16, 12) . $hyphen
        // . substr($charid, 20, 16);
        return $uuid;
    }

}
