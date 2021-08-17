<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function pre_print($array)
{   
    echo count($array);
    echo "<pre>";
    print_r($array);
    exit;
}

function ptPretyAmount($amount)
{
    return number_format($amount, 2, '.', ',');
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

function checkSubscriptionExpiration($expireDate)
{
    if($expireDate == NULL){
        return "expired";
    }else{
        $date1 = strtotime($expireDate);
        if($date1 >= strtotime(date('Y-m-d'))){
            return 'active';
        }else{
            return 'expired';
        }
    }
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

// function menu($seg,$array)
// {
//     $rarray = ["","",""];
//     $CI =& get_instance();
//     $path = $CI->uri->segment($seg);
//     foreach($array as $a)
//     {
//         if($path === $a)
//         {
//           $rarray = array("active","active","pcoded-trigger");
//         }
//     }

//     return $rarray;
// }
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

function sendEmail($to,$sub,$msg)
{
    $CI =& get_instance();
    $CI->load->library('email');
    $config = array(
        'protocol'      => 'SMTP',
        'smtp_host' => get_setting()['mail_host'],
        'smtp_port' => get_setting()['mail_port'],
        'smtp_user' => get_setting()['mail_username'],
        'smtp_pass' => get_setting()['mail_pass'],
        'mailtype'      => 'html',
        'charset'       => 'utf-8'
    );
    $CI->email->initialize($config);
    $CI->email->set_mailtype("html");
    $CI->email->set_newline("\r\n");
    $CI->email->to($to);
    $CI->email->from(get_setting()['mail_username']);
    $CI->email->subject($sub);
    $CI->email->message($msg);
    if($CI->email->send()){
        //echo "ok";
    }else{
        //echo $CI->email->print_debugger();
    }
}

// Groom

function getCategory($id)
{
    $CI =& get_instance();   
    return $CI->db->get_where('categories',['id' => $id])->row_array();
}

function generateOtp($user,$user_type,$otp_type,$email = false)
{
    $CI =& get_instance();
    $otp = mt_rand(1000, 9999);
    $data = [
        'user'      => $user,
        'otp'       => $otp,
        'usertype'  => $user_type,
        'otptype'   => $otp_type,
        'used'      => 0,
        'cat'       => _nowDateTime()
    ];
    $CI->db->insert('z_otp',$data);
    return $otp;
}

function roundLatLon($lat)
{
    return round($lat,6);
}

function getOccupations($id)
{
    $CI =& get_instance();   
    return $CI->db->get_where('master_occupations',['id' => $id])->row_array();
}

function getSkills($id)
{
    $CI =& get_instance();   
    return $CI->db->get_where('master_skills',['id' => $id])->row_array();
}

function getBookingId()
{
    $CI =& get_instance();   
    $last_id = $CI->db->order_by('id','desc')->limit(1)->get('booking')->row_array();
    if($last_id){
        return random_string(6).($last_id['id'] + 1);
    }else{
        return random_string(6).'1';
    }
}

function getProviderCode()
{
    $CI =& get_instance();   
    $last_id = $CI->db->order_by('id','desc')->limit(1)->get('service_provider')->row_array();
    if($last_id){
        return random_string(6).($last_id['id'] + 1);
    }else{
        return random_string(6).'1';
    }
}

function getGiftCardId()
{
    $CI =& get_instance();   
    $last_id = $CI->db->order_by('id','desc')->limit(1)->get('gift_card')->row_array();
    if($last_id){
        return random_string(6).($last_id['id'] + 1);
    }else{
        return random_string(6).'1';
    }
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return strtoupper($key);
}

function getPromoAmount($promoCode,$user,$shops)
{
    $CI =& get_instance();
    $CI->db->where_in('shop',$shops); 
    $CI->db->where('promo',$promoCode); 
    $CI->db->where('active','yes'); 
    $promoCode = $CI->db->get('promocodes')->row_array();
    if($promoCode){
        return $promoCode;
    }else{
        return false;
    }
}

function getDiscountAfter($discountAmt,$subTotal,$totalProdAmount)
{
    if ($discountAmt > $totalProdAmount) {
        return number_format((float)$totalProdAmount, 2, '.', '');
    }else{
        return number_format((float)($discountAmt * $subTotal) / $totalProdAmount, 2, '.', '');
    }
}

function getTax($amount,$per)
{
    return number_format((float)(($amount * $per) / 100), 2, '.', '');
}

function formatTwoDecimal($num)
{
    return number_format($num, 2, '.', '');   
}

function getDistinctShopFromCart($user)
{
    $CI =& get_instance();
    $CI->db->distinct();
    $CI->db->select('shop');
    $CI->db->where('user',$user); 
    $CI->db->where('booking',''); 
    $shops = $CI->db->get('booking_products')->result_array();
    $ar = [];
    foreach ($shops as $key => $value) {
        array_push($ar, $value['shop']);
    }
    return $ar;
}

function getDistinctShopFromOwner($user)
{
    $CI =& get_instance();
    $CI->db->distinct();
    $CI->db->select('id');
    $CI->db->where('user',$user); 
    $CI->db->where('df',''); 
    $shops = $CI->db->get('shop')->result_array();
    $ar = [];
    foreach ($shops as $key => $value) {
        array_push($ar, $value['id']);
    }
    return $ar;
}

function number_shorten($number, $precision = 3, $divisors = null) {

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
?>