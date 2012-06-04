<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseSearchF_job extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function initPage($jobId)
	{
		$this->smarty->assign('jobId', $jobId);
		$this->smarty->assign('businessAreaListURL', site_url('enterpriseSearchF_job/getBusinessArea'));
		//取得公司名称
		$query = $this->db->query('SELECT enterprise FROM enterpriseUser WHERE active = 1 AND id = ?', array($this->session->userdata('userId')));
		$enterpriseId = $query->first_row()->enterprise;
		$query = $this->db->query('SELECT name FROM enterprise WHERE active = 1 AND id = ?', array($enterpriseId));
		$this->smarty->assign('userName', $query->first_row()->name);
		//取得城市列表
		$query = $this->db->query('SELECT id, name FROM city WHERE active = 1');
		$this->smarty->assign('cityList', $query->result_array());
		//取得性别列表
		$query = $this->db->query('SELECT id, name FROM sex WHERE active = 1');
		$this->smarty->assign('sexList', $query->result_array());
		//取得身高列表
		$heightList = array(
			1 => '150cm以下',
			2 => '151cm-160cm',
			3 => '161cm-170cm',
			4 => '171cm-180cm',
			5 => '180cm以上'
		);
		$this->smarty->assign('heightList', $heightList);
		//取得学历列表
		$query = $this->db->query('SELECT id, name FROM education WHERE active = 1');
		$this->smarty->assign('educationList', $query->result_array());
		//取得外表相关列表
		$query = $this->db->query('SELECT id, name FROM commonLevel WHERE active = 1');
		$this->smarty->assign('appearanceList', $query->result_array());
		//取得语言表达相关列表
		$query = $this->db->query('SELECT id, name FROM commonLevel WHERE active = 1');
		$this->smarty->assign('expressionList', $query->result_array());
	}

	public function index($jobId)
	{
		$this->initPage($jobId);
		//取得符合条件人才信息
		$query = $this->db->query('CALL getFitTalentF_job(?, ?)', array(
			$jobId,
			NULL
		));
		$this->smarty->assign('talentList', $query->result_array());
		$query->free_all();
		$this->smarty->display('enterpriseSearchF_job.tpl');
	}

	public function search()
	{
		$this->load->helper('string_helper');
		$jobId = emptyToNull($this->input->post('jobId'));
		$this->initPage($jobId);
		$hunter = emptyToNull($this->input->post('hunter'));
		$keyWord = emptyToNull($this->input->post('keyWordD'));
		$city = emptyToNull($this->input->post('city'));
		$businessArea = emptyToNull($this->input->post('businessArea'));
		$sex = emptyToNull($this->input->post('sex'));
		$ageFrom = emptyToNull($this->input->post('ageFrom'));
		$ageTo = emptyToNull($this->input->post('ageTo'));
		$heightFrom = emptyToNull($this->input->post('heightFrom'));
		$heightTo = emptyToNull($this->input->post('heightTo'));
		$education = emptyToNull($this->input->post('education'));
		$appearance = emptyToNull($this->input->post('appearance'));
		$expression = emptyToNull($this->input->post('expression'));
		//设置商区
		if ($businessArea != NULL)
		{
			$query = $this->db->query('SELECT id, name FROM businessArea WHERE active = 1 AND city = ?', array($city));
			$this->smarty->assign('businessAreaList', $query->result_array());
		}
		//处理城市和商区冲突关系
		if ($businessArea != NULL)
		{
			$city = NULL;
		}
		//取得符合条件人才信息
		$query = $this->db->query('CALL getFitTalentSearchF_job(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
			$jobId,
			$hunter,
			$sex,
			$heightFrom,
			$heightTo,
			$education,
			$appearance,
			$expression,
			$city,
			$businessArea,
			NULL,
			NULL
		));
		$this->smarty->assign('talentList', $query->result_array());
		$query->free_all();
		$this->smarty->assign('jobId', $jobId);
		$this->smarty->display('enterpriseSearchF_job.tpl');
	}

	public function getBusinessArea($cityId = NULL)
	{
		if ($cityId == NULL)
		{
			$query = $this->db->query('SELECT id, name FROM businessArea WHERE active = 1');
		}
		else
		{
			$query = $this->db->query('SELECT id, name FROM businessArea WHERE active = 1 AND city = ?', array($cityId));
		}
		$this->smarty->assign('businessAreaList', $query->result_array());
		$this->smarty->display('businessAreaList.tpl');
	}

}

/*end*/
 