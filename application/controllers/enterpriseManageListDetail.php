<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class EnterpriseManageListDetail extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
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
		//取得deal中企业备注
		//取得交易号
		$query = $this->db->query('SELECT enterpriseNote FROM deal WHERE active = 1 AND talent = ? AND job = ?', array(
			$talent,
			$jobId
		));
		if ($query->num_rows() > 0)
		{
			$enterpriseNote = $query->first_row()->enterpriseNote;
			$this->smarty->assign('enterpriseNote', $enterpriseNote);
			$query->free_all();
		}
		$this->smarty->assign('talentInfo', $talentInfo);
		$this->smarty->assign('jobId', $jobId);
		$this->smarty->display('talentDetailForEnterprise2.tpl');
	}

}

/*end*/
