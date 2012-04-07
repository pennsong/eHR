<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * Smarty Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Smarty
 * @author		Kepler Gelotte
 * @link		http://www.coolphptools.com/codeigniter-smarty
 */
require_once (BASEPATH . 'libraries/Smarty/libs/Smarty.class.php');
class CI_Smarty extends Smarty
{
	function __construct()
	{
		parent::__construct();
		$this->compile_dir = APPPATH . "views/templates_c/";
		$this->template_dir = APPPATH . "views/templates/";
		$this->assign('APPPATH', APPPATH);
		$this->assign('BASEPATH', BASEPATH);
		$this->autoload_filters = array('pre' => array('cw_convertSmartyDelimiter'));
		log_message('debug', "Smarty Class Initialized");
	}

	/**
	 *  Parse a template using the Smarty engine
	 *
	 * This is a convenience method that combines assign() and
	 * display() into one step.
	 *
	 * Values to assign are passed in an associative array of
	 * name => value pairs.
	 *
	 * If the output is to be returned as a string to the caller
	 * instead of being output, pass true as the third parameter.
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function view($template, $data = array(), $return = FALSE)
	{
		foreach ($data as $key => $val)
		{
			$this->assign($key, $val);
		}
		if ($return == FALSE)
		{
			$this->display($template);
			return;
		}
		else
		{
			return $this->fetch($template);
		}
	}

}

/* End of file Smarty.php */
