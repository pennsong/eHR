<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class UpdateEnterpriseInfo extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('type') != 'enterpriseUser')
		{
			show_error('非法操作!');
		}
	}

	public function index()
	{
		//取得公司id
		$query = $this->db->query('SELECT enterprise FROM enterpriseUser WHERE active = 1 AND id = ?', array($this->session->userdata('userId')));
		$enterpriseId = $query->first_row()->enterprise;
		//取得公司信息
		$query = $this->db->query('SELECT * FROM enterprise WHERE active =1 AND id = ?', $enterpriseId);
		$this->smarty->assign('enterpriseInfo', $query->first_row('array'));
		$this->smarty->display('updateEnterpriseInfo.tpl');
	}

	public function submit_validate()
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
			//登录失败
			$this->smarty->assign('errorMsg', $var);
		}
		$this->smarty->display('updateEnterpriseInfo.tpl');
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
			$introduction = $this->input->post('introducation');
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
 