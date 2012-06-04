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
		//取得猎头名称
		$this->smarty->assign('userName', $this->session->userdata('userName'));
		//取得企业列表
		$query = $this->db->query('CALL getEnterpriseListF_hunter(?, ?, ?)', array(
			$this->session->userdata('userId'),
			NULL,
			NULL
		));
		$enterpriseList = $query->result_array();
		$query->free_all();
		foreach ($enterpriseList as &$enterprise)
		{
			//取得该企业各状态人数
			//面试人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				2
			));
			$interview2 = $query->first_row()->num;
			$query->free_all();
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				3
			));
			$interview3 = $query->first_row()->num;
			$query->free_all();
			$enterprise['interviewNum'] = $interview2 + $interview3;
			//offer人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				6
			));
			$offer6 = $query->first_row()->num;
			$query->free_all();
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				7
			));
			$offer7 = $query->first_row()->num;
			$query->free_all();
			$enterprise['offerNum'] = $offer6 + $offer7;
			//到岗人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				9
			));
			$onboard = $query->first_row()->num;
			$query->free_all();
			$enterprise['onboardNum'] = $onboard;
			//待定人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				1
			));
			$todo = $query->first_row()->num;
			$query->free_all();
			$enterprise['todoNum'] = $todo;
			//被动拒绝人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				5
			));
			$rejected = $query->first_row()->num;
			$query->free_all();
			$enterprise['rejectedNum'] = $rejected;
			//被动拒绝人数
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				4
			));
			$reject4 = $query->first_row()->num;
			$query->free_all();
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				8
			));
			$reject8 = $query->first_row()->num;
			$query->free_all();
			$query = $this->db->query('CALL getNumF_hunter_enterprise_dealStatus(?, ?, ?)', array(
				$this->session->userdata('userId'),
				$enterprise['id'],
				11
			));
			$reject11 = $query->first_row()->num;
			$query->free_all();
			$enterprise['rejectNum'] = $reject4 + $reject8 + $reject11;
		}
		$this->smarty->assign('enterpriseList', $enterpriseList);
		$this->smarty->display('hunterMain.tpl');
	}

}

/*end*/
 