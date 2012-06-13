<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class HunterManageList extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($enterprise, $type = 'todo')
	{
		$this->smarty->assign('enterprise', $enterprise);
		$this->smarty->assign('type', $type);
		$this->smarty->display('hunterManageList.tpl');
	}

	public function todoStage($enterprise)
	{
		//取得待办阶段(2:邀请面试, 6:发送offer)列表
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			2
		));
		$talentInfoList2 = $query->result_array();
		$this->smarty->assign('talentInfoList2', $talentInfoList2);
		$query->free_all();
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			6
		));
		$talentInfoList6 = $query->result_array();
		$this->smarty->assign('talentInfoList6', $talentInfoList6);
		$query->free_all();
		$this->smarty->assign('enterprise', $enterprise);
		$this->smarty->display('hunterManageList_todoStage.tpl');
	}

	public function otherStage($enterprise)
	{
		//取得offer阶段(5:面试拒绝, 4:拒绝面试, 5:拒绝offer, 7:接受offer, 1:待定)列表
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			5
		));
		$talentInfoList5 = $query->result_array();
		$this->smarty->assign('talentInfoList5', $talentInfoList5);
		$query->free_all();
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			4
		));
		$talentInfoList4 = $query->result_array();
		$this->smarty->assign('talentInfoList4', $talentInfoList4);
		$query->free_all();
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			5
		));
		$talentInfoList5 = $query->result_array();
		$talentInfoList4_5 = array_merge($talentInfoList4, $talentInfoList5);
		$this->smarty->assign('talentInfoList4_5', $talentInfoList4_5);
		$query->free_all();
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			7
		));
		$talentInfoList7 = $query->result_array();
		$this->smarty->assign('talentInfoList7', $talentInfoList7);
		$query->free_all();
		$query = $this->db->query('CALL getInfoF_hunter_enterprise_dealStatus(?, ?, ?)', array(
			$this->session->userdata('userId'),
			$enterprise,
			1
		));
		$talentInfoList1 = $query->result_array();
		$this->smarty->assign('talentInfoList1', $talentInfoList1);
		$query->free_all();
		$this->smarty->assign('enterprise', $enterprise);
		$this->smarty->display('hunterManageList_otherStage.tpl');
	}

}

/*end*/
 