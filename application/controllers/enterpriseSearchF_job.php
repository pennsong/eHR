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
		$this->smarty->assign('jobId', $jobId);
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

	public function getTalentDetailContent($talent, $jobId)
	{
		//取得人才信息
		$query = $this->db->query('CALL getInfoF_talent(?)', array($talent));
		$talentInfo = $query->first_row('array');
		$query->free_all();
		//取得人才适合城市信息
		$query = $this->db->query('CALL getFitCityF_talent(?)', array($talent['id']));
		$talentInfo['cityList'] = '';
		foreach ($query->result_array() as $city)
		{
			$talentInfo['cityList'] .= $city['cityName'].",";
		}
		$query->free_all();
		//取得人才适合商区信息
		$query = $this->db->query('CALL getFitBusinessAreaF_talent(?)', array($talent['id']));
		$talentInfo['businessAreaList'] = '';
		foreach ($query->result_array() as $city)
		{
			$talentInfo['businessAreaList'] .= $city['businessAreaName'];
		}
		$query->free_all();
		//取得猎头信息
		$query = $this->db->query('SELECT name FROM hunter WHERE active = 1 AND id = ?', array($talentInfo['hunter']));
		$hunterName = $query->first_row()->name;
		$this->smarty->assign('hunterName', $hunterName);
		$this->smarty->assign('talentInfo', $talentInfo);
		$this->smarty->assign('jobId', $jobId);
		$this->smarty->display('talentDetailForEnterprise.tpl');
	}

	public function getHunterSuccessNum($hunter)
	{
		//获得对应猎头成功推荐人数
		$query = $this->db->query('CALL getDealSuccessNumF_hunter(?)', array($hunter));
		$hunterSuccessNum = $query->first_row()->num;
		$query->free_all();
		echo '<span class="text1">'.$hunterSuccessNum.'人</span>';
	}

	public function getHunterPoint($hunter)
	{
		//获得对应猎头积分
		$query = $this->db->query('CALL getPointF_hunter(?)', array($hunter));
		$hunterPoint = $query->first_row()->point;
		echo '<span class="text1">'.$hunterPoint.'人</span>';
	}

	public function getHunterRecommendNum($hunter)
	{
		//获得猎头总共推荐人数
		$query = $this->db->query('CALL getDealNumF_hunter(?)', array($hunter));
		$recommendNum = $query->first_row()->num;
		echo '<span class="text1">'.$recommendNum.'人</span>';
	}

	public function getButtonLayout($job, $talent)
	{
		//取得交易id
		$query = $this->db->query('SELECT id FROM deal WHERE active = 1 AND job = ? AND talent = ?', array(
			$job,
			$talent
		));
		if ($query->num_rows() > 0)
		{
			$deal = $query->first_row()->id;
			$this->smarty->assign('deal', $deal);
			//获得交易当前状态
			$query = $this->db->query('CALL getStatusF_deal(?)', array($deal));
			if ($query->num_rows() > 0)
			{
				$status = $query->first_row()->status;
			}
			else
			{
				$status = '0';
			}
			$query->free_all();
		}
		else
		{
			//无交易
			$status = '0';
		}
		//设置面试按钮状态
		$interviewDisabled = TRUE;
		if (in_array($status, array(
			'0',
			'1',
			'3'
		), true))
		{
			$interviewDisabled = FALSE;
		}
		//设置待定按钮状态
		$todoDisabled = TRUE;
		if (in_array($status, array('0'), true))
		{
			$todoDisabled = FALSE;
		}
		//设置拒绝按钮状态
		$rejectDisabled = TRUE;
		if (in_array($status, array(
			'2',
			'3'
		), true))
		{
			$rejectDisabled = FALSE;
		}
		//设置deal状态名
		if ($status != 0)
		{
			$query = $this->db->query('SELECT name FROM dealStatus WHERE id = ?', array($status));
			$dealStatusName = $query->first_row()->name;
		}
		else
		{
			$dealStatusName = '未开始';
		}
		$this->smarty->assign('dealStatusName', $dealStatusName);
		$this->smarty->assign('interviewDisabled', $interviewDisabled);
		$this->smarty->assign('todoDisabled', $todoDisabled);
		$this->smarty->assign('rejectDisabled', $rejectDisabled);
		$this->smarty->display('enterpriseSearchF_job_getButtonLayout.tpl');
	}

	public function createStatusF_deal($talent, $job, $status, $note = '')
	{
		$role = "enterpriseUser";
		$enterPriseUser = $this->session->userdata('userId');
		//新建交易状态
		$this->db->trans_start();
		$query = $this->db->query('SELECT createStatusF_deal(?, ?, ?, ?, ?, ?) vResult', array(
			$talent,
			$job,
			$status,
			emptyToNull(urldecode($note)),
			'enterpriseUser',
			$enterPriseUser
		));
		$result = $query->first_row()->vResult;
		$query->free_all();
		if ($result == 1)
		{
			//新建成功
			$this->db->trans_commit();
			echo 'ok';
		}
		else
		{
			//新建失败
			$this->db->trans_rollback();
			echo 'failed';
		}
	}

	public function getDealHistory($talent, $job)
	{
		//取得交易号
		$query = $this->db->query('SELECT id FROM deal WHERE active = 1 AND talent = ? AND job = ?', array(
			$talent,
			$job
		));
		if ($query->num_rows() > 0)
		{
			$deal = $query->first_row()->id;
			$query = $this->db->query('CALL getHistoryF_deal(?, ?, ?)', array(
				$deal,
				NULL,
				NULL
			));
			if ($query->num_rows() > 0)
			{
				$this->smarty->assign('dealHistory', $query->result_array());
			}
			$query->free_all();
		}
		$this->smarty->display('dealHistory.tpl');
	}

	public function updateDealInfo($job, $talent, $enterpriseNote)
	{
		$this->db->trans_start();
		$query = $this->db->query('SELECT updateDealEnterpriseNote(?, ?, ?) vResult', array(
			$talent,
			$job,
			urldecode($enterpriseNote)
		));
		if ($query->first_row()->vResult == 1)
		{
			$this->db->trans_commit();
			echo "修改成功";
		}
		else
		{
			$this->db->trans_rollback();
			echo "修改失败";
		}
	}

}

/*end*/
 