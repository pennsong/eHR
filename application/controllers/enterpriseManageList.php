<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseManageList extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($job, $type = 'interview')
	{
		$this->smarty->assign('job', $job);
		$this->smarty->assign('type', $type);
		$this->smarty->display('enterpriseManageList.tpl');
	}

	public function interviewStage($job)
	{
		//取得面试阶段(2:邀请面试, 3:接受面试, 4:拒绝面试)列表
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			2,
			NULL,
			NULL
		));
		$talentInfoList2 = $query->result_array();
		$this->smarty->assign('talentInfoList2', $talentInfoList2);
		$query->free_all();
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			3,
			NULL,
			NULL
		));
		$talentInfoList3 = $query->result_array();
		$this->smarty->assign('talentInfoList3', $talentInfoList3);
		$query->free_all();
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			4,
			NULL,
			NULL
		));
		$talentInfoList4 = $query->result_array();
		$this->smarty->assign('talentInfoList4', $talentInfoList4);
		$this->smarty->assign('job', $job);
		$query->free_all();
		$this->smarty->display('enterpriseManageList_interviewStage.tpl');
	}

	public function offerStage($job)
	{
		//取得offer阶段(6:发送offer, 7:接受offer, 8:拒绝offer)列表
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			6,
			NULL,
			NULL
		));
		$talentInfoList6 = $query->result_array();
		$this->smarty->assign('talentInfoList6', $talentInfoList6);
		$query->free_all();
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			7,
			NULL,
			NULL
		));
		$talentInfoList7 = $query->result_array();
		$this->smarty->assign('talentInfoList7', $talentInfoList7);
		$query->free_all();
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			8,
			NULL,
			NULL
		));
		$talentInfoList8 = $query->result_array();
		$this->smarty->assign('talentInfoList8', $talentInfoList8);
		$this->smarty->assign('job', $job);
		$query->free_all();
		$this->smarty->display('enterpriseManageList_offerStage.tpl');
	}

	public function onboardStage($job)
	{
		//取得到岗阶段(9:已到岗, 10:未到岗)列表
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			9,
			NULL,
			NULL
		));
		$talentInfoList9 = $query->result_array();
		$this->smarty->assign('talentInfoList9', $talentInfoList9);
		$query->free_all();
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			10,
			NULL,
			NULL
		));
		$talentInfoList10 = $query->result_array();
		$this->smarty->assign('talentInfoList10', $talentInfoList10);
		$this->smarty->assign('job', $job);
		$query->free_all();
		$this->smarty->display('enterpriseManageList_onboardStage.tpl');
	}

	public function todoStage($job)
	{
		//取得待定阶段(1:已到岗)列表
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			1,
			NULL,
			NULL
		));
		$talentInfoList1 = $query->result_array();
		$this->smarty->assign('talentInfoList1', $talentInfoList1);
		$this->smarty->assign('job', $job);
		$query->free_all();
		$this->smarty->display('enterpriseManageList_todoStage.tpl');
	}

	public function rejectStage($job)
	{
		//取得拒绝阶段(11:拒绝)列表
		$query = $this->db->query('CALL getTalentF_job_status(?, ?, ?, ?)', array(
			$job,
			11,
			NULL,
			NULL
		));
		$talentInfoList11 = $query->result_array();
		$this->smarty->assign('talentInfoList11', $talentInfoList11);
		$this->smarty->assign('job', $job);
		$query->free_all();
		$this->smarty->display('enterpriseManageList_rejectStage.tpl');
	}

}

/*end*/
 