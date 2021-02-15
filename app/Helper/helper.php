<?php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Modules\WareHouses\Entities\Warehouses;
use Modules\Stores\Entities\Stores;
use Modules\Settings\Entities\Settings;
use Modules\Products\Entities\Products;
use Modules\Category\Entities\Category;
use App\Models\WishList;
use Modules\Manu\Entities\Menu;
use Carbon\Carbon;
use App\Http\Controllers\Store\Checkout\Cart;
//use Intervention\Image\Image;
//use DB;
//use Darryldecode\Cart\Cart;
use Modules\Suppliers\Entities\Suppliers;
use App\Models\TransactionalAccounts;
use App\Models\Transactions;
/*_____________________________________________________*/
function errorMsg($errorMsg)
{
	return '<div class="error"><span>'.$errorMsg.'</span></div>';
}
function upload_image($data)

{
	if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['profile_picture']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
		$image->resize($data['width'], null, function ($constraint) {
			$constraint->aspectRatio();
		});
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
		$image->resize(null, $data['height'], function ($constraint) {
			$constraint->aspectRatio();
		});
    } else if($data['width'] && $data['height']) {
		$image = $image->resize($data['width'], $data['height']);
	}
	//dd($image);
	$image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}
function upload_url_image($data)
{
	if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);

	try
    {
        $image = Image::make(file_get_contents($data['file']));
    }
    catch(NotReadableException $e)
    {
        return $data['name'];
    }

	if($data['width'] && $data['height'] && $data['height'] == "auto") {
		$image->resize($data['width'], null, function ($constraint) {
			$constraint->aspectRatio();
		});
	} else if($data['width'] && $data['height'] && $data['width'] == "auto") {
		$image->resize(null, $data['height'], function ($constraint) {
			$constraint->aspectRatio();
		});
    } else if($data['width'] && $data['height']) {
		$image = $image->fit($data['width'], $data['height']);
	}

	$image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}

function upload_user_image($data)
{
    $data['dir'] = 'public/uploads/profile_pictures/';
    $data['width'] =  128;
    $data['height'] =  128;
    $fileExt = $data['profile_picture']->getClientOriginalExtension();
    $data['name'] = 'user_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['profile_picture']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}
function upload_product_image($data)
{
    $data['dir'] = 'public/uploads/products/';
    $data['width'] =  500;
    $data['height'] =  500;
    $fileExt = $data['image']->getClientOriginalExtension();
    $data['name'] = 'product_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['image']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}

function upload_banner_image($data)
{
    $data['dir'] = 'public/uploads/banners/';
    $data['width'] =  500;
    $data['height'] =  500;

    $fileExt = $data['image']->getClientOriginalExtension();
    $data['name'] = 'banner_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['image']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}

function upload_brand_image($data)
{
    $data['dir'] = 'public/uploads/brands/';
    $data['width'] =  200;
    $data['height'] =  60;
    $fileExt = $data['image']->getClientOriginalExtension();
    $data['name'] = 'brand_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['image']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}

function upload_category_image($data)
{
    $data['dir'] = 'public/uploads/category/';
    $data['width'] =  250;
    $data['height'] =  250;
    $fileExt = $data['image_id']->getClientOriginalExtension();
    $data['name'] = 'category_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['image_id']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}
function upload_cms_image($data)
{
    $data['dir'] = 'public/uploads/cms/';
    $data['width'] =  1920;
    $data['height'] =  600;
    $fileExt = $data['image']->getClientOriginalExtension();
    $data['name'] = 'cms_pic'.time().'.'.$fileExt;
    if (!File::isDirectory($data['dir'])) File::makeDirectory($data['dir'], $mode = 0777, true, true);
    $image = Image::make($data['image']->getRealPath());
    //dd($image);
    if($data['width'] && $data['height'] && $data['height'] == "auto") {
        $image->resize($data['width'], null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height'] && $data['width'] == "auto") {
        $image->resize(null, $data['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
    } else if($data['width'] && $data['height']) {
        $image = $image->resize($data['width'], $data['height']);
    }
    //dd($image);
    $image = $image->save($data['dir'] . $data['name']);
    return $data['name'];
}

function uploadFile($data,$destination) {
    $file = $data['product_doc'];


   // echo 'File Name: '.$file->getClientOriginalName();

    $newFileName= 'prodoct_doc_'.time().str_replace(' ','-',$file->getClientOriginalName());

   // echo 'File Extension: '.$file->getClientOriginalExtension();


    //Display File Real Path
  //  echo 'File Real Path: '.$file->getRealPath();


    //Display File Size
  //  echo 'File Size: '.$file->getSize();


    //Display File Mime Type
    //echo 'File Mime Type: '.$file->getMimeType();


    $destinationPath = $destination;
    $file->move($destinationPath,$newFileName);
    return $newFileName;
}





function set_error_delimeter($errors)
{
	$array = array();
	if(count($errors) > 0) {
		foreach ($errors as $error) {
			array_push($array, '<p>'.$error.'</p>');
		}
	}
	return $array;
}
function bootstarp_error_msg($errorMsg)
{
	return '<span class="label label-danger"><i class="fa fa-times-circle"></i>&nbsp;'.$errorMsg.'</span>';
}
function utf8_strtolower($string) {
	static $upper_to_lower;

	if ($upper_to_lower == null) {
		$upper_to_lower = array(
			0x0041 => 0x0061,
			0x03A6 => 0x03C6,
			0x0162 => 0x0163,
			0x00C5 => 0x00E5,
			0x0042 => 0x0062,
			0x0139 => 0x013A,
			0x00C1 => 0x00E1,
			0x0141 => 0x0142,
			0x038E => 0x03CD,
			0x0100 => 0x0101,
			0x0490 => 0x0491,
			0x0394 => 0x03B4,
			0x015A => 0x015B,
			0x0044 => 0x0064,
			0x0393 => 0x03B3,
			0x00D4 => 0x00F4,
			0x042A => 0x044A,
			0x0419 => 0x0439,
			0x0112 => 0x0113,
			0x041C => 0x043C,
			0x015E => 0x015F,
			0x0143 => 0x0144,
			0x00CE => 0x00EE,
			0x040E => 0x045E,
			0x042F => 0x044F,
			0x039A => 0x03BA,
			0x0154 => 0x0155,
			0x0049 => 0x0069,
			0x0053 => 0x0073,
			0x1E1E => 0x1E1F,
			0x0134 => 0x0135,
			0x0427 => 0x0447,
			0x03A0 => 0x03C0,
			0x0418 => 0x0438,
			0x00D3 => 0x00F3,
			0x0420 => 0x0440,
			0x0404 => 0x0454,
			0x0415 => 0x0435,
			0x0429 => 0x0449,
			0x014A => 0x014B,
			0x0411 => 0x0431,
			0x0409 => 0x0459,
			0x1E02 => 0x1E03,
			0x00D6 => 0x00F6,
			0x00D9 => 0x00F9,
			0x004E => 0x006E,
			0x0401 => 0x0451,
			0x03A4 => 0x03C4,
			0x0423 => 0x0443,
			0x015C => 0x015D,
			0x0403 => 0x0453,
			0x03A8 => 0x03C8,
			0x0158 => 0x0159,
			0x0047 => 0x0067,
			0x00C4 => 0x00E4,
			0x0386 => 0x03AC,
			0x0389 => 0x03AE,
			0x0166 => 0x0167,
			0x039E => 0x03BE,
			0x0164 => 0x0165,
			0x0116 => 0x0117,
			0x0108 => 0x0109,
			0x0056 => 0x0076,
			0x00DE => 0x00FE,
			0x0156 => 0x0157,
			0x00DA => 0x00FA,
			0x1E60 => 0x1E61,
			0x1E82 => 0x1E83,
			0x00C2 => 0x00E2,
			0x0118 => 0x0119,
			0x0145 => 0x0146,
			0x0050 => 0x0070,
			0x0150 => 0x0151,
			0x042E => 0x044E,
			0x0128 => 0x0129,
			0x03A7 => 0x03C7,
			0x013D => 0x013E,
			0x0422 => 0x0442,
			0x005A => 0x007A,
			0x0428 => 0x0448,
			0x03A1 => 0x03C1,
			0x1E80 => 0x1E81,
			0x016C => 0x016D,
			0x00D5 => 0x00F5,
			0x0055 => 0x0075,
			0x0176 => 0x0177,
			0x00DC => 0x00FC,
			0x1E56 => 0x1E57,
			0x03A3 => 0x03C3,
			0x041A => 0x043A,
			0x004D => 0x006D,
			0x016A => 0x016B,
			0x0170 => 0x0171,
			0x0424 => 0x0444,
			0x00CC => 0x00EC,
			0x0168 => 0x0169,
			0x039F => 0x03BF,
			0x004B => 0x006B,
			0x00D2 => 0x00F2,
			0x00C0 => 0x00E0,
			0x0414 => 0x0434,
			0x03A9 => 0x03C9,
			0x1E6A => 0x1E6B,
			0x00C3 => 0x00E3,
			0x042D => 0x044D,
			0x0416 => 0x0436,
			0x01A0 => 0x01A1,
			0x010C => 0x010D,
			0x011C => 0x011D,
			0x00D0 => 0x00F0,
			0x013B => 0x013C,
			0x040F => 0x045F,
			0x040A => 0x045A,
			0x00C8 => 0x00E8,
			0x03A5 => 0x03C5,
			0x0046 => 0x0066,
			0x00DD => 0x00FD,
			0x0043 => 0x0063,
			0x021A => 0x021B,
			0x00CA => 0x00EA,
			0x0399 => 0x03B9,
			0x0179 => 0x017A,
			0x00CF => 0x00EF,
			0x01AF => 0x01B0,
			0x0045 => 0x0065,
			0x039B => 0x03BB,
			0x0398 => 0x03B8,
			0x039C => 0x03BC,
			0x040C => 0x045C,
			0x041F => 0x043F,
			0x042C => 0x044C,
			0x00DE => 0x00FE,
			0x00D0 => 0x00F0,
			0x1EF2 => 0x1EF3,
			0x0048 => 0x0068,
			0x00CB => 0x00EB,
			0x0110 => 0x0111,
			0x0413 => 0x0433,
			0x012E => 0x012F,
			0x00C6 => 0x00E6,
			0x0058 => 0x0078,
			0x0160 => 0x0161,
			0x016E => 0x016F,
			0x0391 => 0x03B1,
			0x0407 => 0x0457,
			0x0172 => 0x0173,
			0x0178 => 0x00FF,
			0x004F => 0x006F,
			0x041B => 0x043B,
			0x0395 => 0x03B5,
			0x0425 => 0x0445,
			0x0120 => 0x0121,
			0x017D => 0x017E,
			0x017B => 0x017C,
			0x0396 => 0x03B6,
			0x0392 => 0x03B2,
			0x0388 => 0x03AD,
			0x1E84 => 0x1E85,
			0x0174 => 0x0175,
			0x0051 => 0x0071,
			0x0417 => 0x0437,
			0x1E0A => 0x1E0B,
			0x0147 => 0x0148,
			0x0104 => 0x0105,
			0x0408 => 0x0458,
			0x014C => 0x014D,
			0x00CD => 0x00ED,
			0x0059 => 0x0079,
			0x010A => 0x010B,
			0x038F => 0x03CE,
			0x0052 => 0x0072,
			0x0410 => 0x0430,
			0x0405 => 0x0455,
			0x0402 => 0x0452,
			0x0126 => 0x0127,
			0x0136 => 0x0137,
			0x012A => 0x012B,
			0x038A => 0x03AF,
			0x042B => 0x044B,
			0x004C => 0x006C,
			0x0397 => 0x03B7,
			0x0124 => 0x0125,
			0x0218 => 0x0219,
			0x00DB => 0x00FB,
			0x011E => 0x011F,
			0x041E => 0x043E,
			0x1E40 => 0x1E41,
			0x039D => 0x03BD,
			0x0106 => 0x0107,
			0x03AB => 0x03CB,
			0x0426 => 0x0446,
			0x00DE => 0x00FE,
			0x00C7 => 0x00E7,
			0x03AA => 0x03CA,
			0x0421 => 0x0441,
			0x0412 => 0x0432,
			0x010E => 0x010F,
			0x00D8 => 0x00F8,
			0x0057 => 0x0077,
			0x011A => 0x011B,
			0x0054 => 0x0074,
			0x004A => 0x006A,
			0x040B => 0x045B,
			0x0406 => 0x0456,
			0x0102 => 0x0103,
			0x039B => 0x03BB,
			0x00D1 => 0x00F1,
			0x041D => 0x043D,
			0x038C => 0x03CC,
			0x00C9 => 0x00E9,
			0x00D0 => 0x00F0,
			0x0407 => 0x0457,
			0x0122 => 0x0123
		);
	}

	$unicode = utf8_to_unicode($string);

	if (!$unicode) {
		return false;
	}

	for ($i = 0; $i < count($unicode); $i++) {
		if (isset($upper_to_lower[$unicode[$i]])) {
			$unicode[$i] = $upper_to_lower[$unicode[$i]];
		}
	}

	return unicode_to_utf8($unicode);
}
function utf8_to_unicode($string) {
	$unicode = array();

	for ($i = 0; $i < strlen($string); $i++) {
		$chr = ord($string[$i]);

		if ($chr >= 0 && $chr <= 127) {
			$unicode[] = (ord($string[$i]) * pow(64, 0));
		}

		if ($chr >= 192 && $chr <= 223) {
			$unicode[] = ((ord($string[$i]) - 192) * pow(64, 1) + (ord($string[$i + 1]) - 128) * pow(64, 0));
		}

		if ($chr >= 224 && $chr <= 239) {
			$unicode[] = ((ord($string[$i]) - 224) * pow(64, 2) + (ord($string[$i + 1]) - 128) * pow(64, 1) + (ord($string[$i + 2]) - 128) * pow(64, 0));
		}

		if ($chr >= 240 && $chr <= 247) {
			$unicode[] = ((ord($string[$i]) - 240) * pow(64, 3) + (ord($string[$i + 1]) - 128) * pow(64, 2) + (ord($string[$i + 2]) - 128) * pow(64, 1) + (ord($string[$i + 3]) - 128) * pow(64, 0));
		}

		if ($chr >= 248 && $chr <= 251) {
			$unicode[] = ((ord($string[$i]) - 248) * pow(64, 4) + (ord($string[$i + 1]) - 128) * pow(64, 3) + (ord($string[$i + 2]) - 128) * pow(64, 2) + (ord($string[$i + 3]) - 128) * pow(64, 1) + (ord($string[$i + 4]) - 128) * pow(64, 0));
		}

		if ($chr == 252 || $chr == 253) {
			$unicode[] = ((ord($string[$i]) - 252) * pow(64, 5) + (ord($string[$i + 1]) - 128) * pow(64, 4) + (ord($string[$i + 2]) - 128) * pow(64, 3) + (ord($string[$i + 3]) - 128) * pow(64, 2) + (ord($string[$i + 4]) - 128) * pow(64, 1) + (ord($string[$i + 5]) - 128) * pow(64, 0));
		}
	}

	return $unicode;
}
function unicode_to_utf8($unicode) {
	$string = '';

	for ($i = 0; $i < count($unicode); $i++) {
		if ($unicode[$i] < 128) {
			$string .= chr($unicode[$i]);
		}

		if ($unicode[$i] >= 128 && $unicode[$i] <= 2047) {
			$string .= chr(($unicode[$i] / 64) + 192) . chr(($unicode[$i] % 64) + 128);
		}

		if ($unicode[$i] >= 2048 && $unicode[$i] <= 65535) {
			$string .= chr(($unicode[$i] / 4096) + 224) . chr(128 + (($unicode[$i] / 64) % 64)) . chr(($unicode[$i] % 64) + 128);
		}

		if ($unicode[$i] >= 65536 && $unicode[$i] <= 2097151) {
			$string .= chr(($unicode[$i] / 262144) + 240) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
		}

		if ($unicode[$i] >= 2097152 && $unicode[$i] <= 67108863) {
			$string  .= chr(($unicode[$i] / 16777216) + 248) . chr((($unicode[$i] / 262144) % 64) + 128) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
		}

		if ($unicode[$i] >= 67108864 && $unicode[$i] <= 2147483647) {
			$string .= chr(($unicode[$i] / 1073741824) + 252) . chr((($unicode[$i] / 16777216) % 64) + 128) . chr((($unicode[$i] / 262144) % 64) + 128) . chr(128 + (($unicode[$i] / 4096) % 64)) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
		}
	}

	return $string;
}
function escape($value) {
	if (get_magic_quotes_gpc())
    {
        $value = stripslashes($value);
    }
    return $escaped_str = str_replace("'", "''", $value);
}
function displayTinyIntValue($value){
    if(is_int($value)){
        return ($value == 1) ? "Yes" : "";
    }else{
        return $value;
    }

}
function uploadimage($array) {
	$result = upload_url_image(array(
		"file" => $array['file'],
		"dir" => $array['dir'],
		"name" => $array['name'],
		"width" => (isset($array['width']) ? $array['width'] : NULL),
		"height" => (isset($array['height']) ? $array['height'] : NULL),
	));
	if(isset($array['sizes'])) {
		foreach($array['sizes'] as $size) {
			$values = explode('x',$size);
			$result = upload_url_image(array(
				"file" => $array['file'],
				"dir" => $array['dir'].$size.'/',
				"name" => $array['name'],
				"width" => (isset($values[0]) ? $values[0] : NULL),
				"height" => (isset($values[1]) ? $values[1] : NULL),
			));
		}
	}
}
function make_permalink($permalink, $table)
{
	// convert the string to all lowercase
	$permalink = mb_strtolower($permalink, 'UTF-8');
	// strip out all whitespace
	$permalink_clean = preg_replace('/\s*/', '', $permalink);
	$permalink_clean = preg_replace ('/[^\p{L}\p{N}]/u', '_', $permalink_clean);
	//$permalink_clean = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $permalink_clean);

	$slug = $maybe_slug = $permalink_clean;
    $next = 1;

    while (DB::table($table)->where('slug', '=', $slug)->first()) {
        $slug = "{$maybe_slug}{$next}";
        $next++;
    }
 //dd($slug);
    return $slug;
}
function varify_reCaptcha($siteKey)
{
    $data = array(
        'secret' => config('variable.CAPTCHA_SECRET'),
        'response' => $siteKey
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $captcha_success = json_decode($response);
    return $captcha_success->success;

}
function base64string_encode($s) {
	return str_replace(array('/'), array('||'), base64_encode($s));
}
function base64string_decode($s) {
	return base64_decode(str_replace(array('||'), array('/'), $s));
}
function featuredCaseStudies($limit = 3) {
	return CaseStudy::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->limit($limit)->get();
}



function getDescription($sDescription){
    return '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($sDescription,"\n\r")).'</li>';
}
 function userPermissionsss($userId,$routeNmae)
{
    $authUserRoleId =DB::table('model_has_roles')->where('model_has_roles.model_id',$userId)
        ->pluck('model_has_roles.role_id','model_has_roles.role_id')->first();
    //dd($authUserRoleId);
    $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$authUserRoleId)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    $permissions =[];
    foreach($data['rolePermissions'] as $ids){
        $permissions[] = Permission:: where('id',$ids)->pluck('name')->first();

    }
    //dd($permissions);
    if(isset($permissions) && !in_array($routeNmae,$permissions)){

       $link= 'restricted_access';


    }else{

        $link= '';

    }
    return $link;

}
function MaxSortorder($table){
   // dd('sd');
    $qry = DB::table($table)->max('sort_order');
   // dd($qry);
    if(is_null($qry)){
        $qry=1;

    }
    return $qry+1;

}

function userDetail($id){
    $user = User::find($id);
    return $user;

}

function userDetailName($id){
    $user = User::find($id);
    return $user->first_name.' '.$user->last_name;

}
function wareHousetitle($id){
    //dd($id);
    $ware =Warehouses::find($id);
    $name = $ware['name'];
    //dd($name);
    return $name;

}
function Storetitle($id){
    //dd($id);
    $ware =Stores::find($id);
    $name = $ware['name'];
    //dd($name);
    return $name;

}
function settingsValue($key){
    $settingd = Settings::where('key',$key)->first()['value'];

    return $settingd;

}

function ShowProducts(){
    //dd($id);
    $products = Products::where('status',1)->orderBy('sort_order','desc')->pluck('name','id')->toArray();
   // $name = $ware['name'];
    //dd($name);
    return $products;

}
function CatePoducts($id){
 // dd($id);
    $pcount=0;
    $cats =Category:: with('products')->find($id);
   // dd($cats);
    $catPr = $cats->products->count();

    $pcount = $pcount + $catPr;
    if($cats->childs->count()>0){
        foreach($cats->childs as $child){
            $childPro = $child->products->count();
            $pcount = $pcount + $childPro;
        }

    }
    return $pcount;
}

function BrandsPrpductsCount($brand_id){
    // dd($id);
    $pcount =Products::where(['status'=>1,'brand_id'=>$brand_id])->count();
    return $pcount;
}
function specialCharacter($string, $revert = false){
    $char_1 = '~';
    $rep_char_1 = '/';
    $char_2 = '^';
    $rep_char_2 = ' ';
    $delimiter = '|';
    if($revert){
        $string = str_replace($char_1, $rep_char_1, $string);
        $string = str_replace($char_2, $rep_char_2, $string);
        return $string;
    }else{
        $string = str_replace($char_1, $rep_char_1, $string);
        $string = str_replace($char_2, $rep_char_2, $string);
        return explode($delimiter, $string);
    }
}

function offerProduct($id){
   //dd($id);
    return Products::find($id);

}
function getWishListIds(){
    $list_ids = [];
    if(Auth::guard('user')->user()){
        $list_ids = WishList::where('user_id', Auth::guard('user')->user()->id)->pluck("product_id")->toArray();
    }
    return $list_ids;
}

function main_manu($code='main_menu'){
    return Menu::with('items')->where('code',$code)->first();

}
function getCartTotalItems(){
    $cart = new Cart();
   // dd($cart->getCartTotalItems())
    return $cart->getCartTotalItems();
}
function getCartTotal(){
    $cart = new Cart();
    // dd($cart->getCartTotalItems())
    return number_format($cart->getCartTotal(),2);
}

  function getDiscountType() {
    return [1 => 'Fixed', 2 => '%'];
}

  function getDiscountFor() {
    return [
        1 => 'Cart',
//            2 => 'Product',
//            3 => 'Brand'
    ];
}

  function getCode($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . '-' . substr(md5(uniqid(rand(), true)), 3, 10);
}

 function getDiscountTypeById($id) {
    $types = getDiscountType();
    if (isset($types[$id])) {
        return $types[$id];
    }
}

 function getDiscountForById($id) {
    $types = getDiscountFor();
    if (isset($types[$id])) {
        return $types[$id];
    }
}

function getAccountsType(){
    return [0=>'Select',1 => 'Payables (Suppliers)', 2 => 'Receivables (Customers)',
        3 => 'Bank Balances', 4 => 'Cash In Hands', 5 => 'Cost Of Goods Sold',
        6 => 'Equity', 7 => 'Expenses',8 => 'Fixed Assets',9 => 'Others Payable',10 => 'Others Receivables'];

}

function getAccountsTypeName($key){
    $arr =  [0=>'Select',1 => 'Payables (Suppliers)', 2 => 'Receivables (Customers)',
        3 => 'Bank Balances', 4 => 'Cash In Hands', 5 => 'Cost Of Goods Sold',
        6 => 'Equity', 7 => 'Expenses',8 => 'Fixed Assets',9 => 'Others Payable',10 => 'Others Receivables'];
return  $arr[$key];
}

function getTransactionsType(){
    return [0=>'Select','credit' => 'Credit', 'debit' => 'Debit'];

}
function getTransactionTypeName($key){
    $arr =  [0=>'Select','credit' => 'Credit', 'debit' => 'Debit'];

    return  $arr[$key];
}

function getCoupon(){
    $cart = new Cart();
    return $cart->getCartCoupon();
}

function SupplierName($id){
    $supplier = Suppliers::find($id)['name'];
    return $supplier;
}

function maxcashVoucer(){
    $max = Transactions::count();
    return $max+1;

}
 function getLeopordCities(){
     $curl_handle = curl_init();
     curl_setopt($curl_handle, CURLOPT_URL,
         'http://new.leopardscod.com/webservice/getAllCities/format/json/'); //
    // Write here Test or Production Link
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_POST, 1);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
        'api_key' => '809368491EC48FE5A973000C9F4285D7',
     'api_password' => 'HAMEED@GUL@143'
    ));
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
   return json_decode($buffer);

 }