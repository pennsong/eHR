<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * Purpose:  bridge to code igniter site_url
 * @author penn
 * @param string or array
 */
function smarty_function_cw_ci_site_url($params, &$smarty)
{
	if (!function_exists('site_url'))
	{
		$CI = &get_instance();
		$CI->load->helper('url');
	}
	echo site_url($params['param1']);
}

/*end*/
