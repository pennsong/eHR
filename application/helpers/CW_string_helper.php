<?php
/**
 * CodeIgniter String Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		penn
 * 和input->post('dataName')结合使用空字符串,'null'(不区分大小写)或不存在(false)的变量转换为NULL
 */
// ------------------------------------------------------------------------
function emptyToNull($val)
{
	if ($val === '' || $val === FALSE || (!is_array($val) && strtolower($val) === 'null'))
	{
		return NULL;
	}
	else
	{
		return $val;
	}
}

/*end*/
 