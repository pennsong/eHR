<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class HunterManageListDetail extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getTalentDetailContent($talent, $enterprise)
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
		//取得人才适合行业
		$query = $this->db->query('CALL getFitIndustryF_talent(?)', array($talent['id']));
		$talentInfo['fitIndustryList'] = '';
		foreach ($query->result_array() as $industry)
		{
			$talentInfo['fitIndustryList'] .= $industry['name'].",";
		}
		$query->free_all();
		//取得人才适合行业
		$query = $this->db->query('CALL getUnfitIndustryF_talent(?)', array($talent['id']));
		$talentInfo['unfitIndustryList'] = '';
		foreach ($query->result_array() as $industry)
		{
			$talentInfo['unfitIndustryList'] .= $industry['name'].",";
		}
		$query->free_all();
		//取得猎头信息
		$this->smarty->assign('talentInfo', $talentInfo);
		$this->smarty->assign('enterprise', $enterprise);
		$this->smarty->display('talentDetailForHunter2.tpl');
	}

}

/*end*/
