<?php
/**
 * CodeIgniter String Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		penn
 * 和input->post('dataName')结合使用，把空字符串，null(不区分大小写)或不存在的变量转换为NULL
 */
// ------------------------------------------------------------------------
function emptyToNull($str)
{
	if ($str === '' || $str === FALSE || strtolower($str) === 'null')
	{
		return NULL;
	}
	else
	{
		return $str;
	}
}

/*end*/
 