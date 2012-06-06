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
			1 => array(
				'150cm以下',
				'',
				150
			),
			2 => array(
				'151cm-160cm',
				151,
				160
			),
			3 => array(
				'161cm-170cm',
				161,
				170
			),
			4 => array(
				'171cm-180cm',
				171,
				180
			),
			5 => array(
				'180cm以上',
				181,
				''
			)
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

	public function index($jobId, $offset = 0, $limit = 10)
	{
		if (!ctype_digit($jobId))
		{
			show_error('不合法参数', $status_code = 404);
		}
		$this->initPage($jobId);
		//处理分页
		$this->load->library('pagination');
		$config['base_url'] = site_url('enterpriseSearchF_job/index/'.$jobId);
		$config['uri_segment'] = 4;
		//取得符合条件人才信息条数
		$query = $this->db->query('CALL getFitTalentF_job(?, ?, NULL, NULL)', array(
			$jobId,
			TRUE
		));
		$config['total_rows'] = $query->first_row()->num;
		$query->free_all();
		$config['per_page'] = '10';
		$this->pagination->initialize($config);
		//取得符合条件人才信息
		$query = $this->db->query('CALL getFitTalentF_job(?, ?, ?, ?)', array(
			$jobId,
			NULL,
			$offset,
			$limit
		));
		$talentList = $query->result_array();
		$query->free_all();
		//取得人才信息
		foreach ($talentList as &$talent)
		{
			//取得人才适合城市信息
			$query = $this->db->query('CALL getFitCityF_talent(?)', array($talent['id']));
			$talent['cityList'] = '';
			foreach ($query->result_array() as $city)
			{
				$talent['cityList'] .= $city['cityName'].",";
			}
			$query->free_all();
			//取得人才适合商区信息
			$query = $this->db->query('CALL getFitBusinessAreaF_talent(?)', array($talent['id']));
			$talent['businessAreaList'] = '';
			foreach ($query->result_array() as $city)
			{
				$talent['businessAreaList'] .= $city['businessAreaName'];
			}
			$query->free_all();
			//取得人才信息
			$query = $this->db->query('CALL getInfoF_talent(?)', array($talent['id']));
			$talent = array_merge($talent, $query->first_row('array'));
			$query->free_all();
		}
		$this->smarty->assign('talentList', $talentList);
		$this->smarty->display('enterpriseSearchF_job.tpl');
	}

	public function search($offset = 0, $limit = 10)
	{
		$this->load->helper('string_helper');
		$jobId = emptyToNull($this->input->post('jobId'));
		if (!ctype_digit($jobId))
		{
			show_error('不合法参数', $status_code = 404);
		}
		$this->initPage($jobId);
		$hunter = emptyToNull($this->input->post('hunter'));
		$keyWord = emptyToNull($this->input->post('keyWord'));
		$city = emptyToNull($this->input->post('city'));
		$businessArea = emptyToNull($this->input->post('businessArea'));
		$sex = emptyToNull($this->input->post('sex'));
		$ageFrom = emptyToNull($this->input->post('ageFrom'));
		$ageTo = emptyToNull($this->input->post('ageTo'));
		$height = emptyToNull($this->input->post('height'));
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
		//处理分页
		$this->load->library('pagination');
		$config['full_tag_open'] = '<div class="locPage">';
		$config['full_tag_close'] = '</div>';
		$config['base_url'] = '';
		$config['uri_segment'] = 3;
		//取得符合条件人才信息条数
		$query = $this->db->query('CALL getFitTalentSearchF_job(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
			$jobId,
			$keyWord,
			$hunter,
			$sex,
			$heightFrom,
			$heightTo,
			$education,
			$appearance,
			$expression,
			$city,
			$businessArea,
			TRUE,
			NULL,
			NULL
		));
		$config['total_rows'] = $query->first_row()->num;
		$query->free_all();
		$config['per_page'] = '10';
		$this->pagination->initialize($config);
		//取得符合条件人才信息
		$query = $this->db->query('CALL getFitTalentSearchF_job(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
			$jobId,
			$keyWord,
			$hunter,
			$sex,
			$heightFrom,
			$heightTo,
			$education,
			$appearance,
			$expression,
			$city,
			$businessArea,
			FALSE,
			$offset,
			$limit
		));
		$talentList = $query->result_array();
		$query->free_all();
		//取得人才信息
		foreach ($talentList as &$talent)
		{
			//取得人才适合城市信息
			$query = $this->db->query('CALL getFitCityF_talent(?)', array($talent['id']));
			$talent['cityList'] = '';
			foreach ($query->result_array() as $city)
			{
				$talent['cityList'] .= $city['cityName'].",";
			}
			$query->free_all();
			//取得人才适合商区信息
			$query = $this->db->query('CALL getFitBusinessAreaF_talent(?)', array($talent['id']));
			$talent['businessAreaList'] = '';
			foreach ($query->result_array() as $city)
			{
				$talent['businessAreaList'] .= $city['businessAreaName'];
			}
			$query->free_all();
			//取得人才信息
			$query = $this->db->query('CALL getInfoF_talent(?)', array($talent['id']));
			$talent = array_merge($talent, $query->first_row('array'));
			$query->free_all();
		}
		$this->smarty->assign('talentList', $talentList);
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

	public function getTalentDetailContent($talent)
	{
		//取得人才信息
		$query = $this->db->query('CALL getInfoF_talent(?)', array($talent));
		$talentInfo = $query->first_row('array');
		$query->free_all();
		//获得对应猎头成功推荐人数
		$query = $this->db->query('CALL getDealSuccessNumF_hunter(?)', array($talentInfo['hunter']));
		$hunterSuccessNum = $query->first_row()->num;
		$query->free_all();
		//获得对应猎头积分
		$query = $this->db->query('CALL getPointF_hunter(?)', array($talentInfo['hunter']));
		$hunterPoint = $query->first_row()->point;
		$query->free_all();
		$this->smarty->assign('talentInfo', $talentInfo);
		$this->smarty->assign('hunterSuccessNum', $hunterSuccessNum);
		$this->smarty->assign('hunterPoint', $hunterPoint);
		$this->smarty->assign('talent', $talent);
		$this->smarty->display('talentDetailForEnterprise.tpl');
	}

}

/*end*/
 