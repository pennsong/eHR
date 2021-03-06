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
		$this->initMasterData();
		//取得职位信息
		$query = $this->db->query('SELECT * FROM job WHERE active =1 AND id = ?', $job);
		$jobInfo = $query->first_row('array');
		$jobInfo['job'] = $jobInfo['id'];
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
		$jobInfo['bonusList'] = $jobBonusList;
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
		$jobInfo['welfareList'] = $jobWelfareList;
		//取得当前职位语言列表
		$query = $this->db->query('SELECT language, commonLevel FROM jobLanguage WHERE active =1 AND job=?', array($job));
		$jobLanguageList = array();
		$jobLanguageLevelList = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				array_push($jobLanguageList, $row->language);
				array_push($jobLanguageLevelList, $row->commonLevel);
			}
		}
		$jobInfo['languageList'] = $jobLanguageList;
		$jobInfo['languageLevelList'] = $jobLanguageLevelList;
		$_POST = $jobInfo;
		$this->smarty->display('updateJob.tpl');
	}

	public function createJob()
	{
		$this->initMasterData();
		$this->smarty->display('createJob.tpl');
	}

	public function validate($type)
	{
		$var = '';
		//空字符串,'null'(不区分大小写)或不存在(false)的变量转换为NULL
		foreach ($_POST as &$val)
		{
			$val = emptyToNull($val);
		}
		//处理城市和商区的关系，只要有商区，就把城市设为空
		if ($this->input->post('businessArea') != NULL)
		{
			$_POST['city'] = NULL;
		}
		if ($this->authenticate($var, $type))
		{
			//成功
			$this->smarty->assign('okMsg', '成功!');
		}
		else
		{
			//失败
			$this->smarty->assign('errorMsg', $var);
		}
		$this->initMasterData();
		if ($type == 'update')
		{
			$this->smarty->display('updateJob.tpl');
		}
		else if ($type == 'create')
		{
			$this->smarty->display('createJob.tpl');
		}
	}

	public function saveUpdate(&$var)
	{
		$this->db->trans_start();
		//更新表job
		$query = $this->db->query('SELECT updateJob(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result', array(
			$this->input->post('job'),
			$this->input->post('title'),
			$this->input->post('requireNumber'),
			$this->input->post('workType'),
			$this->input->post('contractType'),
			$this->input->post('workTime'),
			$this->input->post('city'),
			$this->input->post('businessArea'),
			$this->input->post('onboardDate'),
			$this->input->post('salaryFrom'),
			NULL,
			$this->input->post('commissionDate'),
			$this->input->post('sex'),
			$this->input->post('ageFrom'),
			$this->input->post('ageTo'),
			$this->input->post('heightFrom'),
			$this->input->post('heightTo'),
			$this->input->post('education'),
			$this->input->post('specialSkill'),
			$this->input->post('detail')
		));
		if ($query->first_row()->result == 1)
		{
			//处理jobBonus
			//删除原有记录
			if ($this->db->query('DELETE FROM jobBonus WHERE job = ?', array($this->input->post('job'))))
			{
				//插入新记录
				if ($this->input->post('bonusList') != NULL)
				{
					foreach ($this->input->post('bonusList') as $bonus)
					{
						if ($this->db->query('INSERT INTO jobBonus(`job`, `bonus`, `updated`, `created`) VALUES(?, ?, null, null)', array(
							$this->input->post('job'),
							$bonus
						)))
						{
						}
						else
						{
							$var = '数据保存失败(新建jobBonus出错)!';
							break;
						}
					}
				}
			}
			else
			{
				$var = '数据保存失败!(删除原有jobBonus记录出错)';
			}
			if ($var == NULL)
			{
				//处理jobLanguage
				//删除原有记录
				if ($this->db->query('DELETE FROM jobLanguage WHERE job = ?', array($this->input->post('job'))))
				{
					//插入新记录
					if ($this->input->post('languageList') != NULL)
					{
						$languageLevelList = $this->input->post('languageLevelList');
						$tmpIndex = 0;
						foreach ($this->input->post('languageList') as $language)
						{
							if ($this->db->query('INSERT INTO jobLanguage(`job`, `language`, `commonLevel`, `updated`, `created`) VALUES(?, ?, ?, null, null)', array(
								$this->input->post('job'),
								$language,
								$languageLevelList[$tmpIndex++]
							)))
							{
							}
							else
							{
								$var = '数据保存失败(新建jobLanguage出错)!';
								break;
							}
						}
					}
				}
				else
				{
					$var = '数据保存失败!(删除原有jobLanguage记录出错)';
				}
			}
			if ($var == NULL)
			{
				//处理jobWelfare
				//删除原有记录
				if ($this->db->query('DELETE FROM jobWelfare WHERE job = ?', array($this->input->post('job'))))
				{
					//插入新记录
					if ($this->input->post('welfareList') != NULL)
					{
						foreach ($this->input->post('welfareList') as $welfare)
						{
							if ($this->db->query('INSERT INTO jobWelfare(`job`, `welfare`, `updated`, `created`) VALUES(?, ?, null, null)', array(
								$this->input->post('job'),
								$welfare
							)))
							{
							}
							else
							{
								$var = '数据保存失败(新建jobWelfare出错)!';
								break;
							}
						}
					}
				}
				else
				{
					$var = '数据保存失败!(删除原有jobWelfare记录出错)';
				}
			}
			if ($var == NULL)
			{
				$this->db->trans_commit();
				return TRUE;
			}
			else
			{
				$this->db->trans_rollback();
				return FALSE;
			}
		}
		else
		{
			$var = '数据保存失败(插入job出错)!';
			$this->db->trans_rollback();
			return FALSE;
		}
	}

	public function saveCreate(&$var)
	{
		$this->db->trans_start();
		//创建job
		$query = $this->db->query('SELECT createJob(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result', array(
			$this->session->userdata('userId'),
			$this->input->post('title'),
			$this->input->post('requireNumber'),
			$this->input->post('workType'),
			$this->input->post('contractType'),
			$this->input->post('workTime'),
			$this->input->post('city'),
			$this->input->post('businessArea'),
			$this->input->post('onboardDate'),
			$this->input->post('salaryFrom'),
			NULL,
			$this->input->post('commissionDate'),
			$this->input->post('sex'),
			$this->input->post('ageFrom'),
			$this->input->post('ageTo'),
			$this->input->post('heightFrom'),
			$this->input->post('heightTo'),
			$this->input->post('education'),
			$this->input->post('specialSkill'),
			$this->input->post('detail')
		));
		if (($job = $query->first_row()->result) > 0)
		{
			//处理jobBonus
			//插入新记录
			if ($this->input->post('bonusList') != NULL)
			{
				foreach ($this->input->post('bonusList') as $bonus)
				{
					if ($this->db->query('INSERT INTO jobBonus(`job`, `bonus`, `updated`, `created`) VALUES(?, ?, null, null)', array(
						$job,
						$bonus
					)))
					{
					}
					else
					{
						$var = '数据保存失败(新建jobBonus出错)!';
						break;
					}
				}
			}
			if ($var == NULL)
			{
				//处理jobLanguage
				//插入新记录
				if ($this->input->post('languageList') != NULL)
				{
					$languageLevelList = $this->input->post('languageLevelList');
					$tmpIndex = 0;
					foreach ($this->input->post('languageList') as $language)
					{
						if ($this->db->query('INSERT INTO jobLanguage(`job`, `language`, `commonLevel`, `updated`, `created`) VALUES(?, ?, ?, null, null)', array(
							$job,
							$language,
							$languageLevelList[$tmpIndex++]
						)))
						{
						}
						else
						{
							$var = '数据保存失败(新建jobLanguage出错)!';
							break;
						}
					}
				}
			}
			if ($var == NULL)
			{
				//处理jobWelfare
				//插入新记录
				if ($this->input->post('welfareList') != NULL)
				{
					foreach ($this->input->post('welfareList') as $welfare)
					{
						if ($this->db->query('INSERT INTO jobWelfare(`job`, `welfare`, `updated`, `created`) VALUES(?, ?, null, null)', array(
							$job,
							$welfare
						)))
						{
						}
						else
						{
							$var = '数据保存失败(新建jobWelfare出错)!';
							break;
						}
					}
				}
			}
			if ($var == NULL)
			{
				$this->db->trans_commit();
				return TRUE;
			}
			else
			{
				$this->db->trans_rollback();
				return FALSE;
			}
		}
		else
		{
			$var = '数据保存失败(创建job出错)!';
			$this->db->trans_rollback();
			return FALSE;
		}
	}

	public function authenticate(&$var, $type)
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
			if ($type == 'update')
			{
				if ($this->saveUpdate($var))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else if ($type == 'create')
			{
				if ($this->saveCreate($var))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
	}

	private function _checkDataFormat(&$result)
	{
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'title',
				'label' => '职位名称',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'requireNumber',
				'label' => '招聘人数',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'workType',
				'label' => '工作性质',
				'rules' => 'required|is_natural_no_zero'
			),
			array(
				'field' => 'contractType',
				'label' => '合同性质',
				'rules' => 'required|is_natural_no_zero'
			),
			array(
				'field' => 'workTime',
				'label' => '工作时间',
				'rules' => 'required|is_natural_no_zero'
			),
			array(
				'field' => 'city',
				'label' => '城市',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'businessArea',
				'label' => '商区',
				'rules' => 'is_natural_no_zero|callback_validateCityBusinessArea'
			),
			array(
				'field' => 'onboardDate',
				'label' => '预计到岗日期',
				'rules' => 'callback_validateDate'
			),
			array(
				'field' => 'salaryFrom',
				'label' => '薪水',
				'rules' => 'required|is_natural_no_zero'
			),
			array(
				'field' => 'bonus[]',
				'label' => '奖金',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'welfare[]',
				'label' => '福利',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'commissionDate',
				'label' => '佣金获取日',
				'rules' => 'required|is_natural_no_zero'
			),
			array(
				'field' => 'sex',
				'label' => '性别',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'ageFrom',
				'label' => '年龄下限',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'ageTo',
				'label' => '年龄上限',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'heightFrom',
				'label' => '身高下限',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'heightTo',
				'label' => '身高上限',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'education',
				'label' => '学历',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'languageList[]',
				'label' => '语言',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'languageLevelList[]',
				'label' => '语言水平',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'detail',
				'label' => '岗位表述',
				'rules' => 'required'
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

	public function validateDate($dateString)
	{
		$reg = '/^(19|20)[0-9]{2}[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])$/';
		$result = preg_match($reg, $dateString);
		if ($result == 0)
		{
			$this->form_validation->set_message('validateDate', '%s 不是合法的日期格式');
			return FALSE;
		}
		else
		{
			$order = array(
				"-",
				" ",
				"/",
				"."
			);
			$replace = ',';
			$newStr = str_replace($order, $replace, $dateString);
			$dateArray = explode(",", $newStr);
			if (checkdate($dateArray[1], $dateArray[2], $dateArray[0]))
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('validateDate', '%s 不是合法的日期格式');
				return FALSE;
			}
		}
	}

	public function validateCityBusinessArea($str)
	{
		if (($this->input->post('city') == null) && ($this->input->post('businessArea') == null))
		{
			$this->form_validation->set_message('validateCityBusinessArea', '城市和商区不能都为空');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function initMasterData()
	{
		//取得工作性质列表
		$query = $this->db->query('SELECT id, name FROM workType WHERE active =1');
		$workTypeList = array('' => '请选择');
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
		$contractTypeList = array('' => '请选择');
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
		$workTimeList = array('' => '请选择');
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$workTimeList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('workTimeList', $workTimeList);
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
		//取得佣金获取日列表
		$query = $this->db->query('SELECT id, name FROM commissionDate WHERE active =1');
		$commissionDateList = array('' => '请选择');
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
		$sexList = array('' => '请选择');
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
		$educationList = array('' => '请选择');
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
		$commonLevelList = array('' => '请选择');
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
		$languageList = array('' => '请选择');
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$languageList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('languageList', $languageList);
	}

	public function addLanguage()
	{
		//取得通用水平列表
		$query = $this->db->query('SELECT id, name FROM commonLevel WHERE active =1');
		$commonLevelList = array('' => '请选择');
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
		$languageList = array('' => '请选择');
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$languageList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('languageList', $languageList);
		$this->smarty->display('jobInfo_addLanguage.tpl');
	}

	public function setCityBusinessArea($city = null, $businessArea = null)
	{
		$city = emptyToNull($city);
		$businessArea = emptyToNull($businessArea);
		//取得城市列表
		$query = $this->db->query('SELECT id, name FROM city WHERE active =1');
		$cityList = array('' => '请选择');
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$cityList[$row->id] = $row->name;
			}
		}
		$this->smarty->assign('cityList', $cityList);
		$businessAreaList = array('' => '请选择');
		//商区不为空
		if ($businessArea != NULL)
		{
			//取得商区所属城市
			$query = $this->db->query('SELECT city FROM businessArea WHERE active =1 AND id=?', array($businessArea));
			$city = $query->first_row()->city;
			$this->smarty->assign('city', $city);
			$this->smarty->assign('businessArea', $businessArea);
			//取得商区列表
			$query = $this->db->query('SELECT id, name FROM businessArea WHERE active =1 AND city=?', array($city));
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					$businessAreaList[$row->id] = $row->name;
				}
			}
		}
		//商区为空
		else
		{
			if ($city == NULL)
			{
			}
			else
			{
				$this->smarty->assign('city', $city);
				//取得商区列表
				$query = $this->db->query('SELECT id, name FROM businessArea WHERE active =1 AND city=?', array($city));
				if ($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{
						$businessAreaList[$row->id] = $row->name;
					}
				}
			}
		}
		$this->smarty->assign('businessAreaList', $businessAreaList);
		$this->smarty->display('jobInfo_setCityBusinessArea.tpl');
	}

}

/*end*/
 