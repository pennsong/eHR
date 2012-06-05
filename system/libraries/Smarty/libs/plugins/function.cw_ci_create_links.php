<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * Purpose:  bridge to code igniter pagination->create_links()
 * @author penn
 * @param none
 */
function smarty_function_cw_ci_create_links($params, &$smarty)
{
	$CI = &get_instance();
	echo $CI->pagination->create_links();
}

/*end*/
