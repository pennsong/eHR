<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class JobInfo extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('type') != 'enterpriseUser')
		{
			show_error('非法操作!');
		}
	}

	public function index($job)
	{
		//取得职位信息
		$query = $this->db->query('SELECT * FROM job WHERE active =1 AND id = ?', $job);
		$this->smarty->assign('jobInfo', $query->first_row('array'));
		//取得工作性质列表
		$query = $this->db->query('SELECT id, name FROM workType WHERE active =1');
		$workTypeList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$workTypeList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('workTypeList', $workTypeList);
		//取得合同类型列表
		$query = $this->db->query('SELECT id, name FROM contractType WHERE active =1');
		$contractTypeList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$contractTypeList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('contractTypeList', $contractTypeList);
		//取得工作时间列表
		$query = $this->db->query('SELECT id, name FROM workTime WHERE active =1');
		$workTimeList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$workTimeList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('workTimeList', $workTimeList);
		//取得城市列表
		$query = $this->db->query('SELECT id, name FROM city WHERE active =1');
		$cityList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$cityList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('cityList', $cityList);
		//取得商区列表
		$query = $this->db->query('SELECT id, name FROM businessArea WHERE active =1');
		$businessAreaList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$businessAreaList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('businessAreaList', $businessAreaList);
		//取得奖金列表
		$query = $this->db->query('SELECT id, name FROM bonus WHERE active =1');
		$bonusList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$bonusList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('bonusList', $bonusList);
		//取得当前职位奖金列表
		$query = $this->db->query('SELECT bonus FROM jobBonus WHERE active=1 AND job=?', array($job));
		$jobBonusList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				array_push($jobBonusList, $row->bonus);
			}
		}
		$this->smarty->assign('jobBonusList', $jobBonusList);
		//取得福利列表
		$query = $this->db->query('SELECT id, name FROM welfare WHERE active =1');
		$welfareList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$welfareList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('welfareList', $welfareList);
		//取得当前职位福利列表
		$query = $this->db->query('SELECT welfare FROM jobWelfare WHERE active=1 AND job=?', array($job));
		$jobWelfareList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				array_push($jobWelfareList, $row->welfare);
			}
		}
		$this->smarty->assign('jobWelfareList', $jobWelfareList);
		//取得佣金获取日列表
		$query = $this->db->query('SELECT id, name FROM commissionDate WHERE active =1');
		$commissionDateList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$commissionDateList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('commissionDateList', $commissionDateList);
		//取得性别列表
		$query = $this->db->query('SELECT id, name FROM sex WHERE active =1');
		$sexList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$sexList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('sexList', $sexList);
		//取得学历列表
		$query = $this->db->query('SELECT id, name FROM education WHERE active =1');
		$educationList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$educationList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('educationList', $educationList);
		//取得通用水平列表
		$query = $this->db->query('SELECT id, name FROM commonLevel WHERE active =1');
		$commonLevelList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$commonLevelList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('commonLevelList', $commonLevelList);
		//取得语言列表
		$query = $this->db->query('SELECT id, name FROM language WHERE active =1');
		$languageList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$languageList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('languageList', $languageList);
		//取得当前职位语言列表
		$query = $this->db->query('SELECT language, commonLevel FROM jobLanguage WHERE active =1 AND job=?', array($job));
		$jobLanguageList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$jobLanguageList[$row->language] = $row->commonLevel;
			}
		}
		$this->smarty->assign('jobLanguageList', $jobLanguageList);
		$this->smarty->display('updateJob.tpl');
	}

	public function validateUpdate()
	{
		$var = '';
		$enterpriseInfo['id'] = $this->input->post('enterprise');
		$enterpriseInfo['name'] = $this->input->post('name');
		$enterpriseInfo['phone'] = $this->input->post('phone');
		$enterpriseInfo['mail'] = $this->input->post('mail');
		$enterpriseInfo['address'] = $this->input->post('address');
		$enterpriseInfo['introduction'] = $this->input->post('introduction');
		$this->smarty->assign('enterpriseInfo', $enterpriseInfo);
		if ($this->authenticate($var))
		{
			//成功
			$this->smarty->assign('okMsg', '更新成功!');
		}
		else
		{
			//失败
			$this->smarty->assign('errorMsg', $var);
		}
		$this->smarty->display('updateEnterprise.tpl');
	}

	public function authenticate(&$var)
	{
		$this->lang->load('form_validation', 'chinese');
		//检查数据格式
		if (!($this->_checkDataFormat($result)))
		{
			$var = $result;
			return FALSE;
		}
		//保存数据
		else
		{
			$enterprise = $this->input->post('enterprise');
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$mail = $this->input->post('mail');
			$address = $this->input->post('address');
			$introduction = $this->input->post('introduction');
			$query = $this->db->query('SELECT updateEnterprise(?, ?, ?, ?, ?, ?) result', array(
				$enterprise,
				$name,
				$phone,
				$mail,
				$address,
				$introduction
			));
			if ($query->first_row()->result == 1)
			{
				return TRUE;
			}
			else
			{
				$var = '数据保存失败!';
				return FLASE;
			}
		}
	}

	private function _checkDataFormat(&$result)
	{
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'name',
				'label' => '公司名称',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'phone',
				'label' => '电话',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'mail',
				'label' => '邮件',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'address',
				'label' => '地址',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'introduction',
				'label' => '简介',
				'rules' => 'required|alpha_numeric_chinese'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error1">*', '</span><br>');
		if ($this->form_validation->run() == FALSE)
		{
			$result = validation_errors();
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

/*end*/
 