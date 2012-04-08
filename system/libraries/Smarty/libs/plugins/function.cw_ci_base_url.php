<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * Purpose:  bridge to code igniter base_url
 * @author penn
 * @param null
 */
function smarty_function_cw_ci_base_url($params, &$smarty)
{
	if (!function_exists('base_url'))
	{
		$CI = &get_instance();
		$CI->load->helper('url');
	}
	echo base_url();
}

/*end*/
