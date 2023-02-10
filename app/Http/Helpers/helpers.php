<?php

use Carbon\Carbon;
use App\Lib\SendSms;
use App\Models\Currency;
use App\Models\EmailLog;
use App\Models\Frontend;
use App\Models\ChargeLog;
use App\Models\Extension;
use App\Models\SmsTemplate;
use App\Models\EmailTemplate;
use App\Models\ModuleSetting;
use App\Models\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;




function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if ($old) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }
    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $image = Image::make($file);
    if ($size) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1]);
    }
    $image->save($location . '/' . $filename);

    if ($thumb) {
        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }

    return $filename;
}

function uploadFile($file, $location, $size = null, $old = null){
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if ($old) {
        removeFile($location . '/' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $file->move($location,$filename);
    return $filename;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}


function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}


function getImage($image,$size = null)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }else{
        return asset('images/default.png');
    }
    if ($size) {
        return route('placeholder.image',$size);
    }else{
        return asset('images/default.png');
    }

}



function getPaginate($paginate = 20)
{
    return $paginate;
}

 function paginateLinks($data, $design = 'admin.partials.paginate'){
    return $data->appends(request()->all())->links($design);
 }




function sanitizedParam($param) {
    $pattern[0]     = ",";
    $pattern[1]     = "#";
    $pattern[2]     = "(";
    $pattern[3]     = ")";
    $pattern[4]     = "{";
    $pattern[5]     = "}";
    $pattern[6]     = "<";
    $pattern[7]     = ">";
    $pattern[8]     = "`";
    $pattern[9]     = "!";
    $pattern[10]    = ":";
    $pattern[11]    = "'";
    $pattern[12]    = ";";
    $pattern[13]    = "~";
    $pattern[14]    = "\[";
    $pattern[15]    = "\]";
    $pattern[16]    = "\*";
    $pattern[17]    = "&";
    $pattern[18]    = ".";

    $sanitizedParam = str_replace($pattern, "", $param);
    return $sanitizedParam;
}


function imagePath()
{
    $data['group'] = [
        'path' => 'images/groups',
        'size' => '800x800',
    ];
    $data['post'] = [
        'path' => 'images/groups/post',
    ];

    $data['image'] = [
        'default' => 'assets/images/default.png',
    ];
    $data['profile'] = [
        'user'=> [
            'path'=>'assets/images/user/profile',
            'size'=>'350x300'
        ],

    ];


    return $data;
}
function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}
function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'Y-m-d h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}
function showDate($date, $format = 'd M Y ')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}


