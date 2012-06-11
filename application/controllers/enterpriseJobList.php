<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseJobList extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//取得职位列表
		$query = $this->db->query('CALL getJobListF_enterpriseUser(?, ?, ?)', array(
			$this->session->userdata('userId'),
			NULL,
			NULL
		));
		$jobList = $query->result_array();
		$query->free_all();
		$this->smarty->assign('jobList', $jobList);
		$this->smarty->display('enterpriseJobList.tpl');
	}

}

/*end*/
 