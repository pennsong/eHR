<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseMain extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//取得公司名称
		$query = $this->db->query('SELECT enterprise FROM enterpriseUser WHERE active = 1 AND id = ?', array($this->session->userdata('userId')));
		$enterpriseId = $query->first_row()->enterprise;
		$query = $this->db->query('SELECT name FROM enterprise WHERE active = 1 AND id = ?', array($enterpriseId));
		$this->smarty->assign('userName', $query->first_row()->name);
		//取得职位列表
		$query = $this->db->query('CALL getJobListF_enterpriseUser(?, ?, ?)', array(
			$this->session->userdata('userId'),
			NULL,
			NULL
		));
		$jobList = $query->result_array();
		$query->free_all();
		foreach ($jobList as &$job)
		{
			$query = $this->db->query('CALL getFitTalentF_job(?, ?)', array($job['id'], TRUE));
			$job['fitNum'] = $query->first_row()->num;
			$query->free_all();
			$query = $this->db->query('CALL getChosenTalentNumF_job(?)', array($job['id']));
			$job['choseNum'] = $query->first_row()->num;
			$query->free_all();
		}
		$this->smarty->assign('jobList', $jobList);
		$this->smarty->display('enterpriseMain.tpl');
	}

}

/*end*/
 