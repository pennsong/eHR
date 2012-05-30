<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class HunterMain extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->display('hunterMain.tpl');
	}
}
/*end*/