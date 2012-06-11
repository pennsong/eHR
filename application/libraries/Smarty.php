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
require_once (BASEPATH.'libraries/Smarty/libs/Smarty.class.php');
class CI_Smarty extends Smarty
{
	function __construct()
	{
		parent::__construct();
		$CI = &get_instance();
		$this->assign('CI', $CI);
		$this->compile_dir = APPPATH."views/templates_c/";
		$this->template_dir = APPPATH."views/templates/";
		$this->assign('APPPATH', APPPATH);
		$this->assign('BASEPATH', BASEPATH);
		$this->autoload_filters = array('pre' => array('cw_convertSmartyDelimiter'));
		log_message('debug', "Smarty Class Initialized");
	}

}

/* End of file Smarty.php */
 