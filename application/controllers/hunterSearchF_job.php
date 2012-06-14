<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class HunterSearchF_job extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function initPage()
	{
		$this->smarty->assign('businessAreaListURL', site_url('enterpriseSearchF_job/getBusinessArea'));
		//取得城市列表
		$query = $this->db->query('SELECT id, name FROM city WHERE active = 1');
		$this->smarty->assign('cityList', $query->result_array());
		//取得商区列表
		$query = $this->db->query('SELECT id, name FROM businessArea WHERE active = 1');
		$this->smarty->assign('businessAreaList', $query->result_array());
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
		//取得适合行业列表
		$query = $this->db->query('SELECT id, name FROM industry WHERE active = 1');
		$this->smarty->assign('fitIndustryList', $query->result_array());
		//取得不适合行业列表
		$query = $this->db->query('SELECT id, name FROM industry WHERE active = 1');
		$this->smarty->assign('unfitIndustryList', $query->result_array());
	}

	public function index($offset = 0, $limit = 10)
	{
		$this->initPage();
		$hunter = $this->session->userdata('userId');
		//处理分页
		$this->load->library('pagination');
		$config['base_url'] = site_url('hunterSearchF_job/index/');
		$config['uri_segment'] = 3;
		//取得符合条件人才信息条数
		$query = $this->db->query('SELECT count(*) num FROM talent WHERE hunter = ?', array($hunter));
		$config['total_rows'] = $query->first_row()->num;
		$query->free_all();
		$config['per_page'] = '10';
		$this->pagination->initialize($config);
		//取得符合条件人才信息
		$query = $this->db->query('SELECT * FROM talent WHERE hunter = ? LIMIT ?, ?', array(
			(int)$hunter,
			(int)$offset,
			(int)$limit
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
		$this->smarty->display('hunterSearchF_job.tpl');
	}

	public function search($offset = 0, $limit = 10)
	{
		$this->initPage();
		$this->load->helper('string_helper');
		$hunter = $this->session->userdata('userId');
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
		$query = $this->db->query('CALL getTalentSearchF_hunter(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
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
		$query = $this->db->query('CALL getTalentSearchF_hunter(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(
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
		$this->smarty->display('hunterSearchF_job.tpl');
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
		$this->initPage();
		//取得人才信息
		$query = $this->db->query('CALL getInfoF_talent(?)', array($talent));
		$talentInfo = $query->first_row('array');
		$talentInfo['talent'] = $talentInfo['id'];
		$query->free_all();
		//取得人才适合城市信息
		$query = $this->db->query('CALL getFitCityF_talent(?)', array($talent));
		$talentInfo['cityList'] = $query->result_array();
		$query->free_all();
		//取得人才适合商区信息
		$query = $this->db->query('CALL getFitBusinessAreaF_talent(?)', array($talent));
		$talentInfo['businessAreaList'] = $query->result_array();
		$query->free_all();
		//取得人才适合行业
		$query = $this->db->query('CALL getFitIndustryF_talent(?)', array($talent));
		$talentInfo['fitIndustryList'] = $query->result_array();
		$query->free_all();
		//取得人才适合行业
		$query = $this->db->query('CALL getUnfitIndustryF_talent(?)', array($talent));
		$talentInfo['unfitIndustryList'] = $query->result_array();
		$query->free_all();
		$_POST = $talentInfo;
		$this->smarty->display('talentDetailForHunter.tpl');
	}

	public function validate()
	{
		$var = '';
		//空字符串,'null'(不区分大小写)或不存在(false)的变量转换为NULL,并把ajax递交的数组转换回来
		foreach ($_POST as &$val)
		{
			$val = emptyToNull($val);
			if (strstr($val, '_'))
			{
				$val = str_replace(",", "", $val);
				$val = explode('_', $val);
				array_pop($val);
			}
		}
		$this->initPage();
		if ($this->authenticate($var))
		{
			//成功
			$this->smarty->assign('okMsg', '成功!');
			$this->smarty->display('talentDetailForHunter.tpl');
		}
		else
		{
			//失败
			$this->smarty->assign('errorMsg', $var);
			$this->smarty->display('talentDetailForHunter.tpl');
		}
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
			if ($this->saveUpdate($var))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}

	public function saveUpdate(&$var)
	{
		$this->db->trans_start();
		//更新表talent表
		$query = $this->db->query('SELECT updateTalent(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result', array(
			$this->input->post('talent'),
			$this->input->post('talentPersonName'),
			$this->input->post('birthYear'),
			$this->input->post('photoURL'),
			$this->input->post('videoURL'),
			$this->input->post('sex'),
			$this->input->post('marriage'),
			$this->input->post('height'),
			$this->input->post('education'),
			$this->input->post('appearance'),
			$this->input->post('expression'),
			$this->input->post('hunterNote'),
			$this->input->post('release')
		));
		if ($query->first_row()->result == 1)
		{
			//处理城市
			//删除原有记录
			if ($this->db->query('DELETE FROM talentFitCity WHERE talent = ?', array($this->input->post('talent'))))
			{
				//插入新记录
				if ($this->input->post('cityList') != NULL)
				{
					foreach ($this->input->post('cityList') as $city)
					{
						if ($this->db->query('INSERT INTO talentFitCity(`talent`, `city`, `updated`, `created`) VALUES(?, ?, null, null)', array(
							$this->input->post('talent'),
							$city
						)))
						{
						}
						else
						{
							$var = '数据保存失败(新建talentFitCity出错)!';
							break;
						}
					}
				}
			}
			else
			{
				$var = '数据保存失败!(删除原有talentFitCity记录出错)';
			}
			//处理商区
			if ($var == NULL)
			{
				//删除原有记录
				if ($this->db->query('DELETE FROM talentFitBusinessArea WHERE talent = ?', array($this->input->post('talent'))))
				{
					//插入新记录
					if ($this->input->post('businessAreaList') != NULL)
					{
						foreach ($this->input->post('businessAreaList') as $businessArea)
						{
							if ($this->db->query('INSERT INTO talentFitBusinessArea(`talent`, `businessArea`, `updated`, `created`) VALUES(?, ?, null, null)', array(
								$this->input->post('talent'),
								$businessArea
							)))
							{
							}
							else
							{
								$var = '数据保存失败(talentFitBusinessArea)!';
								break;
							}
						}
					}
				}
			}
			//处理适合行业
			if ($var == NULL)
			{
				//删除原有记录
				if ($this->db->query('DELETE FROM talentFitIndustry WHERE talent = ?', array($this->input->post('talent'))))
				{
					//插入新记录
					if ($this->input->post('fitIndustryList') != NULL)
					{
						foreach ($this->input->post('fitIndustryList') as $fitIndustry)
						{
							if ($this->db->query('INSERT INTO talentFitIndustry(`talent`, `industry`, `updated`, `created`) VALUES(?, ?, null, null)', array(
								$this->input->post('talent'),
								$fitIndustry
							)))
							{
							}
							else
							{
								$var = '数据保存失败(talentFitIndustry)!';
								break;
							}
						}
					}
				}
			}
			//处理不适合行业
			if ($var == NULL)
			{
				//删除原有记录
				if ($this->db->query('DELETE FROM talentUnfitIndustry WHERE talent = ?', array($this->input->post('talent'))))
				{
					//插入新记录
					if ($this->input->post('unfitIndustryList') != NULL)
					{
						foreach ($this->input->post('unfitIndustryList') as $unfitIndustry)
						{
							if ($this->db->query('INSERT INTO talentUnfitIndustry(`talent`, `industry`, `updated`, `created`) VALUES(?, ?, null, null)', array(
								$this->input->post('talent'),
								$unfitIndustry
							)))
							{
							}
							else
							{
								$var = '数据保存失败(talentUnfitIndustry)!';
								break;
							}
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
			$var = '数据保存失败(更新talent表)!';
			$this->db->trans_rollback();
			return FALSE;
		}
	}

	private function _checkDataFormat(&$result)
	{
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'cityList[]',
				'label' => '城市',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'businessAreaList[]',
				'label' => '商区',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'sex',
				'label' => '性别',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'marriage',
				'label' => '婚否',
				'rules' => 'is_natural'
			),
			array(
				'field' => 'height',
				'label' => '身高',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'education',
				'label' => '教育',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'appearance',
				'label' => '外表相关',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'expression',
				'label' => '语言表达相关',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'fitIndustry[]',
				'label' => '适合行业',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'unfitIndustry[]',
				'label' => '不适合行业',
				'rules' => 'is_natural_no_zero'
			),
			array(
				'field' => 'release',
				'label' => '发布',
				'rules' => 'is_natural'
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
 