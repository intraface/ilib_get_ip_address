<?php
/**
 * An improved <code>array_map</code> which can be used recursively
 *
 * Function can be dynamically changed at runtime
 *
 * @package get_ip_address
 * @author  Lars Olesen <lars@legestue.net>
 */

if (!function_exists('get_ip_address')) {
  /**
   * This function is dynamically redefinable.
   * @see $GLOBALS['_global_function_callback_get_ip_address']
   */
  function get_ip_address($args) {
    $args = func_get_args();
    return call_user_func_array($GLOBALS['_global_function_callback_get_ip_address'], $args);
  }
  if (!isset($GLOBALS['_global_function_callback_get_ip_address'])) {
    $GLOBALS['_global_function_callback_get_ip_address'] = 'ilib_get_ip_address';
  }
}
/**
 * An improved function to get the ip address
 *
 * @return string
 */
function ilib_get_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_expl = explode('.', $_SERVER['HTTP_IP_CLIENT']);
        $referer = explode('.', $_SERVER['REMOTE_ADDR']);
        if ($referer[0] != $ip_expl[0]) {
            $ip = array_reverse($ip_expl);
            $return = implode('.', $ip);
        } else {
            // @todo an error here
            $return = $client_ip;
        }
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strstr($_SERVER['HTTP_X_FORWARDED_FOR'], '.')) {
            $ip_expl = explode('.', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $return = end($ip_expl);
        } else {
            $return = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $return = $_SERVER['REMOTE_ADDR'];
    } else {
        $return = '';
    }
    return $return;
}
