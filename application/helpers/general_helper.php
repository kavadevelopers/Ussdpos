<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function pre_print($array)
{   
    echo count($array);
    echo "<pre>";
    print_r($array);
    exit;
}

function niara()
{
    return "₦";
}

function traType($type)
{
    if ($type == 1) {
        return ['ussd','1'];
    }else if($type == 2){
        return ['fees','2'];
    }else if($type == 3){
        return ['posorder','3'];
    }
}

function traTypeArray()
{
    return [1,2,3];
}

function ptPretyAmount($amount)
{
    return number_format($amount, 2, '.', ',');
}

function posPurchaseOption($val)
{
    if ($val == "1") {
        return "Lease Purchase";
    }else if ($val == "2") {
        return "Lease Rent";
    }else{
        return "Outright Purchase";
    }
}

function deliveryType($t)
{
    if ($t == "1") {
        return "GIG Logistics";
    }else{
        return "Local Bus";
    }
}

function retJson($array){
    header("Content-type: application/json");
    echo json_encode($array);
}

function _vdatetime($datetime)
{
	return date('d-m-Y h:i A',strtotime($datetime));
}

function _sortdate($datetime)
{
    if($datetime!=""){
        return date('Ymd',strtotime($datetime));
    }else{
        return "";
    }
}

function selected($val,$val2,$val3 = false){
    $ret = "";
    if($val == $val2){
        $ret = "selected";
    }

    if($val3 && $ret == ''){
        if($val == $val3){
            $ret = "selected";       
        }
    }
    return $ret;
}

function _nowDateTime()
{   
    return date('Y-m-d H:i:s');
}

function getYesterday()
{
    return date('Y-m-d',strtotime("-1 day",strtotime(date('Y-m-d'))));
}

function plusMonth($month,$date)
{
    return date('Y-m-d',strtotime("+".$month." months",strtotime($date)));   
}

function vd($date)
{
    return date('d-m-Y',strtotime($date));
}

function vfd($date)
{
    return date('F d, Y',strtotime($date));
}

function dd($date)
{
    return date('Y-m-d',strtotime($date));
}


function dt($time){
    return date('H:i:s',strtotime($time));   
}

function vt($time){
    return date('h:i A',strtotime($time));   
}

function getPretyDateTime($date)
{
    return date('d M Y h:i A',strtotime($date));
}

function getPretyDate($date)
{
    return date('d M Y',strtotime($date));
}

function getPretyTime($time)
{
    return date('h:i A',strtotime($time));
}

function subStrr($str, $length = 125, $append = '...') {
    if (strlen($str) > $length) {
        $delim = "~\n~";
        $str = substr($str, 0, strpos(wordwrap($str, $length, $delim), $delim)) . $append;
    } 
    return $str;
}

function getFileExtension($filename){
    return pathinfo($filename, PATHINFO_EXTENSION);
}

function get_setting()
{
	$ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('setting',['id' => '1'])->row_array();
}

function get_user(){
	$ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('user',['id' => $ci->session->userdata('id')])->row_array();	
}

function get_user_byid($id){
    $ci=& get_instance();
    return $ci->db->get_where('user',['id' => $id])->row_array();  
}

function menu($seg,$iarray,$parent = false)
{
    $array = ["","",""];
    $CI =& get_instance();
    if(!$parent){
        $path = $CI->uri->segment($seg);
        foreach($iarray as $a)
        {
            if($path === $a)
            {
              $array = array("active kava-active","active kava-active","pcoded-trigger kava-active"); 
            }
        }
    }else{
        $path = $CI->uri->segment($seg);
        foreach($iarray as $a)
        {
            if($parent == $CI->uri->segment(1) && $path === $a)
            {
              $array = array("active kava-active","active kava-active","pcoded-trigger kava-active"); 
            }
        }
    }
    return $array;
}

function docRejectReasons()
{
    $ar = [
        'Image not clear',
        'Out of date utility bill, must be the 3 last months',
        'Address not Visible or content not readable',
        'Retake full utility bill Image',
        'Retake clear passport Photo',
        'Invalid ID card type'
    ];
    return $ar;
}


// Groom

function roundLatLon($lat)
{
    return round($lat,6);
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return strtoupper($key);
}

function getTax($amount,$per)
{
    return number_format((float)(($amount * $per) / 100), 2, '.', '');
}

function formatTwoDecimal($num)
{
    return number_format($num, 2, '.', '');   
}

function number_shorten($number, $precision = 2, $divisors = null) {

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );    
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}

function number_shortenNum($number, $precision = 2, $divisors = null) {

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );    
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    if(is_decimal($number / $divisor)){
        return number_format($number / $divisor, $precision) . $shorthand;
    }else{
        return number_format($number / $divisor, 0) . $shorthand;
    }
}
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}
function date_range_list($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
    while( $current <= $last ) {
        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}

function stringReadMoreInline($str,$length) {
    $strOk = nl2br($str);
    if (strlen($str) > $length) {
        $delim = "~\n~";
        $append = '<span style="display:none;" class="full-string-span">'.substr($strOk,$length,strlen($str)).'</span><a href="#" class="link inline-readmore"><small>...more</small></a>';
        $str = substr($strOk,0,$length).$append;
    }
    return $str;
}  
?>