<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TEST : PRINT ARRAY
if (!function_exists('show_arr')) {
    function show_arr($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        exit();
    }
}

/*
 * get Message from Language file
 */
if (!function_exists('lang')) {
    function lang($key, $params = array())
    {
        $CI = &get_instance();
        if ($CI->lang->line($key) === false) {
            return $key;
        }
        $line = $CI->lang->line($key);
        if (count($params) > 0) {
            return vsprintf($line, $params);
        }
        return $line;
    }
}

// TEST : PRINT LAST EXECUTED QUERY
if (!function_exists('last_query')) {
    function last_query()
    {
        $CI = &get_instance();
        return $CI->db->last_query();

    }
}

if (!function_exists('logMessage')) {
    function logMessage($operation, $parameters, $response)
    {
        $Parameters = Json_encode($parameters);
        $Response = Json_encode($response);
        log_message('error', 'Ranking Star => Api Name:' . $operation . ' , parameters:' . $Parameters . ' , response:' . $Response);

    }
}

if(!function_exists('adminLogMessage')){
    function adminLogMessage($operation,$parameters,$output){
        $Parameters = Json_encode($parameters);
        log_message('error','Ranking Star => Operation:'.$operation.' , parameters:' .$Parameters.' , Insert/Update/Delete ID:' .$output);
    }

}


// ================= DATE TIME ===================== // $result = gmdate ( CON_DB_DATETIME_FORMAT, strtotime ( "+" . $min . " minutes" ));
if (! function_exists ( 'current_datetime' )) {
	function current_datetime() {
        $result = date(CON_DB_DATETIME_FORMAT);
        return $result;
    }
}


if (! function_exists ( 'add_min_to_datetime' )) {
	function add_min_to_datetime($min) {
		$result = date ( CON_DB_DATETIME_FORMAT, strtotime ( "+" . $min . " minutes" ));
        return $result;
    }
}
