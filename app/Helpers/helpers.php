<?php

use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

function currentUser($guard, $field = null){
    if($field){
        return Auth::guard($guard)->user()->getAttribute($field);
    }
    return Auth::guard($guard)->user();
}

function admin($field = null){
    return currentUser('admin', $field);
}

function manager($field = null){
    return currentUser('manager', $field);
}

function rewards(){
    return [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'instagram' => 'Instagram',
        'pinterest' => 'Pinterest'
    ];
}

function listingStatuses(){
    return [
        0 => 'draft',
        1 => 'pending',
        2 => 'approved',
        3 => 'live',
        4 => 'ended',
    ];
}

function randomImg($dir = 'assets/img/dev')
{
    $dir = public_path().'/'.$dir;
    $files = glob($dir . '/*.*');
    if(is_array($files)) {
        $file = array_rand($files);
        $fInfo = new finfo(FILEINFO_MIME_TYPE);

        return new UploadedFile(
            $files[$file],
            'new_file',
            $fInfo->file($files[$file]),
            filesize($files[$file]),
            0,
            false
        );
    } else {
        return '';
    }
}

function excerpt($sentence, $count = 10) {
    $excerpt = '';
    $sentence = strip_tags($sentence);
    if($sentence) {
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
        if($matches[0]) {
            $excerpt = $matches[0].'...';
        }
    }
    return $excerpt;
}

function friyayDay(){
    return 'Friday';
}

function friyayHour(){
    return '18:00:00';
}

function friyayTime($format = null){
    $now = time();

    if(strtolower(date('l', $now)) === strtolower(friyayDay()) && (strtotime('today '.friyayHour()) - $now > 0)){
        $friyay = strtotime('today '.friyayHour());
    } else {
        $friyay = strtotime('next '.friyayDay().' '.friyayHour());
    }

    if($format){
        $friyay = date($format, $friyay);
    }

    return $friyay;
}

function friyayTimeUnitsLeft($friyay = null){

    if(!$friyay){
        $friyay = friyayTime();
    }

    $difference = $friyay - time();

    $units = 'seconds';
    if($difference > 60*60*24) {
        $units = 'days';
    } elseif($difference > 60*60) {
        $units = 'hours';
    } elseif($difference > 60){
        $units = 'minutes';
    }

    return $units;
}

function generateMap($location){
    $loc = implode(',',[$location->get('lat'), $location->get('lon')]);
    $key = env('GOOGLE_MAPS_API');
    $parameters = [
        'scale' => 2,
        'zoom' => 16,
        'size' => '300x250',
        'maptype' => 'roadmap',
        'markers' => 'size:mid|color:0xff0000|label:|'.$loc,
        'key' => $key,
        'format' => 'png',
        'center' => $loc
    ];
    $link = "http://maps.googleapis.com/maps/api/staticmap?".http_build_query($parameters);

    $info = pathinfo($link);
    $contents = file_get_contents($link);
    $temp = '/tmp/' . $info['basename'];
    file_put_contents($temp, $contents);
    $uploaded_file = new UploadedFile($temp, $info['basename']);

    $file = new File();
    $file->saveFile('maps', $uploaded_file);

    return  $file;
}

function showViewIfExists($view){
    if(view()->exists($view)){
        try {
            return view($view)->render();
        } catch (Throwable $e) {
            abort('404');
        }
    }
    abort('404');
}

function fullUrl($url){
    if(strncasecmp('http', $url, 4)){
        return 'http://'.$url;
    } else {
        return $url;
    }
}

function cleanUrl($url){
    $url = ltrim($url, 'http://');
    $url = ltrim($url, 'https://');
    $url = trim($url, '/');
    $parts = explode('/', $url);
    return $parts[0];
}