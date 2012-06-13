<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class hunterInfo extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($hunter)
	{
		//取得猎头信息
		$query = $this->db->query('SELECT * FROM hunter WHERE active =1 AND id = ?', $hunter);
		if ($query->num_rows() > 0)
		{
			$hunterInfo = $query->first_row('array');
			$hunterInfo['hunter'] = $hunter;
			$_POST = $hunterInfo;
			$this->smarty->display('updateHunter.tpl');
		}
	}

	public function noLogin_register()
	{
		$this->smarty->display('registerHunter.tpl');
	}

	public function noLogin_validate($type)
	{
		$var = '';
		//空字符串,'null'(不区分大小写)或不存在(false)的变量转换为NULL
		foreach ($_POST as &$val)
		{
			$val = emptyToNull($val);
		}
		if ($this->authenticate($var, $type))
		{
			//成功
			$this->smarty->assign('okMsg', '成功!');
			if ($type == 'update')
			{
				$this->smarty->display('updateHunter.tpl');
			}
			else if ($type == 'create')
			{
				redirect(base_url()."index.php/login/login2/{$this->input->post('name')}/{$this->input->post('password')}");
			}
		}
		else
		{
			//失败
			$this->smarty->assign('errorMsg', $var);
			if ($type == 'update')
			{
				$this->smarty->display('updateHunter.tpl');
			}
			else if ($type == 'create')
			{
				$this->smarty->display('registerHunter.tpl');
			}
		}
	}

	public function authenticate(&$var, $type)
	{
		$this->lang->load('form_validation', 'chinese');
		//检查数据格式
		if (!($this->_checkDataFormat($result, $type)))
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

	public function saveCreate(&$var)
	{
		$this->db->trans_start();
		//更新表hunter
		$query = $this->db->query('SELECT createHunter(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result', array(
			strtolower($this->input->post('name')),
			strtolower($this->input->post('password')),
			$this->input->post('fixphone1'),
			$this->input->post('fixphone2'),
			$this->input->post('fixphone3'),
			$this->input->post('mobile'),
			$this->input->post('personName'),
			$this->input->post('idNo'),
			$this->input->post('address'),
			$this->input->post('bankNo'),
			$this->input->post('bankName')
		));
		if ($query->first_row()->result == 1)
		{
			$this->db->trans_commit();
			return TRUE;
		}
		else
		{
			$var = '数据保存失败!';
			$this->db->trans_rollback();
			return FALSE;
		}
	}

	public function saveUpdate(&$var)
	{
		$this->db->trans_start();
		//更新表hunter
		$query = $this->db->query('SELECT updateHunter(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result', array(
			strtolower($this->input->post('hunter')),
			strtolower($this->input->post('password')),
			$this->input->post('fixphone1'),
			$this->input->post('fixphone2'),
			$this->input->post('fixphone3'),
			$this->input->post('mobile'),
			$this->input->post('personName'),
			$this->input->post('idNo'),
			$this->input->post('address'),
			$this->input->post('bankNo'),
			$this->input->post('bankName')
		));
		if ($query->first_row()->result == 1)
		{
			$this->db->trans_commit();
			return TRUE;
		}
		else
		{
			$var = '数据保存失败!';
			$this->db->trans_rollback();
			return FALSE;
		}
	}

	private function _checkDataFormat(&$result, $type)
	{
		$this->load->library('form_validation');
		if ($type == 'create')
		{
			$config = array( array(
					'field' => 'name',
					'label' => '用户名',
					'rules' => 'required|alpha_numeric|min_length[6]|max_length[14]|callback_checkNameExisting'
				));
		}
		else if ($type == 'update')
		{
			$config = array();
		}
		else
		{
			return FALSE;
		}
		$config = array_merge($config, array(
			array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'required|alpha_numeric|min_length[6]|max_length[14]'
			),
			array(
				'field' => 'passwordConfirm',
				'label' => '确认密码',
				'rules' => 'required|matches[password]'
			),
			array(
				'field' => 'fixphone1',
				'label' => '区号',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'fixphone2',
				'label' => '座机号码',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'fixphone3',
				'label' => '分机号码',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'mobile',
				'label' => '手机',
				'rules' => 'required|numeric|exact_length[11]|callback_mobileCheck'
			),
			array(
				'field' => 'personName',
				'label' => '人名',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'idNo',
				'label' => '身份证号码',
				'rules' => 'required|callback_checkIdNo'
			),
			array(
				'field' => 'address',
				'label' => '常用地址',
				'rules' => 'required|alpha_numeric_chinese'
			),
			array(
				'field' => 'bankNo',
				'label' => '银行卡帐号',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'bankName',
				'label' => '银行卡开户行',
				'rules' => 'required|alpha_numeric_chinese'
			)
		));
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

	public function checkNameExisting($str)
	{
		$request = $this->db->query('SELECT * FROM hunter WHERE name = ?', strtolower($str));
		if ($request->num_rows() > 0)
		{
			$this->form_validation->set_message('checkNameExisting', '%s用户名已存在，请重新输入');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function checkMobile($str)
	{
		$r1 = preg_match("/^1[3581].*$/", $str);
		if ($r1 == 0)
		{
			$this->form_validation->set_message('checkMobile', '手机号码填写错误，请重新填写');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function checkIdNo($str)
	{
		if (strlen($str) != 15 && strlen($str) != 18)
		{
			$this->form_validation->set_message('checkIdNo', '身份证号码位数错误，请重新填写');
			return FALSE;
		}
		else
		{
			if (strlen($str) == 15)
			{
				$str = $this->_idcard_15to18($str);
			}
			if ($this->_idcard_checksum18($str))
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('checkIdNo', '身份证号码填写错误，请重新填写');
				return FALSE;
			}
		}
	}

	// 计算身份证校验码，根据国家标准GB 11643-1999
	private function _idcard_verify_number($idcard_base)
	{
		if (strlen($idcard_base) != 17)
		{
			return FALSE;
		}
		// 加权因子
		$factor = array(
			7,
			9,
			10,
			5,
			8,
			4,
			2,
			1,
			6,
			3,
			7,
			9,
			10,
			5,
			8,
			4,
			2
		);
		// 校验码对应值
		$verify_number_list = array(
			'1',
			'0',
			'X',
			'9',
			'8',
			'7',
			'6',
			'5',
			'4',
			'3',
			'2'
		);
		$checksum = 0;
		for ($i = 0; $i < strlen($idcard_base); $i++)
		{
			$checksum += substr($idcard_base, $i, 1) * $factor[$i];
		}
		$mod = $checksum % 11;
		$verify_number = $verify_number_list[$mod];
		return $verify_number;
	}

	// 将15位身份证升级到18位
	private function _idcard_15to18($idcard)
	{
		if (strlen($idcard) != 15)
		{
			return FALSE;
		}
		else
		{
			// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
			if (array_search(substr($idcard, 12, 3), array(
				'996',
				'997',
				'998',
				'999'
			)) !== FALSE)
			{
				$idcard = substr($idcard, 0, 6).'18'.substr($idcard, 6, 9);
			}
			else
			{
				$idcard = substr($idcard, 0, 6).'19'.substr($idcard, 6, 9);
			}
		}
		$idcard = $idcard.$this->_idcard_verify_number($idcard);
		return $idcard;
	}

	// 18位身份证校验码有效性检查
	private function _idcard_checksum18($idcard)
	{
		if (strlen($idcard) != 18)
		{
			return FALSE;
		}
		$idcard_base = substr($idcard, 0, 17);
		if ($this->_idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1)))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

/*end*/
 