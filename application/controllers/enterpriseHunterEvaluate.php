<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseHunterEvaluate extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($hunter)
	{
		//取得猎头信息
		$query = $this->db->query('SELECT id, personName FROM hunter WHERE active = 1 AND id = ?', $hunter);
		if ($query->num_rows() > 0)
		{
			$this->smarty->assign('hunterInfo', $query->first_row('array'));
			//取得猎头为本企业用户推荐人才信息
			$query = $this->db->query('CALL getCandidateNumF_hunter_enterpriseUser(?, ?)', array(
				$hunter,
				$this->session->userdata('userId')
			));
			$this->smarty->assign('hunterTalentInfo', $query->result_array());
			$query->free_all();
			//取得猎头得到的评语
			$query = $this->db->query('CALL getRemarkFromEnterpriseF_hunter(?)', array($hunter));
			$this->smarty->assign('enterpriseRemarkList', $query->result_array());
			$query->free_all();
			$this->smarty->display('enterpriseHunterEvaluate.tpl');
		}
	}

}

/*end*/
 