<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Login extends CW_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('cookie');
	}

	public function index()
	{
		//set user type
		$this->smarty->assign('typeId', array(
			'1',
			'2'
		));
		$this->smarty->assign('typeName', array(
			'猎头',
			'企业用户'
		));
		if ($this->input->cookie('type'))
		{
			$this->smarty->assign('type', $this->input->cookie('type'));
		}
		$this->smarty->display('login.tpl');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url()."index.php/login");
	}

	public function login2($userName = null, $password = null, $type = 1)
	{
		$_POST['type'] = $type;
		$_POST['userName'] = $userName;
		$_POST['password'] = $password;
		$this->submit_validate();
	}

	public function submit_validate()
	{
		$var = '';
		if ($this->authenticate($var))
		{
			//登录成功
			$this->input->set_cookie('type', $this->input->post('type'), 3600 * 24 * 30);
			if ($this->session->userdata('type') == 'hunter')
			{
				redirect(base_url().'index.php/hunterMain');
			}
			else if ($this->session->userdata('type') == 'enterpriseUser')
			{
				redirect(base_url().'index.php/enterpriseMain');
			}
		}
		else
		{
			//登录失败
			$this->smarty->assign('loginErrorInfo', $var);
			$this->index();
		}
	}

	private function _checkDataFormat(&$result)
	{
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'userName',
				'label' => '用户名',
				'rules' => 'required|callback_username_check1|callback_username_check2|callback_username_check3'
			),
			array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'required|alpha_numeric|min_length[6]|max_length[20]'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('*', '<br>');
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

	public function username_check1($str)
	{
		$r1 = preg_match("/^[\w\.]{6,15}$/", $str);
		if ($r1 == 0)
		{
			$this->form_validation->set_message('username_check1', '%s 只能包含英文字母，数字，下划线和点,长度为6-15.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function username_check2($str)
	{
		$docNum = substr_count($str, '.');
		$lineNum = substr_count($str, '_');
		if ($docNum + $lineNum > 1)
		{
			$this->form_validation->set_message('username_check2', '%s 只能包含一个下划线或点.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function username_check3($str)
	{
		$r1 = preg_match("/^\..*/", $str);
		$r2 = preg_match("/^_.*/", $str);
		$r3 = preg_match("/.*\.$/", $str);
		$r4 = preg_match("/.*_$/", $str);
		if ($r1 || $r2 || $r3 || $r4)
		{
			$this->form_validation->set_message('username_check3', '%s 不能以下划线或点开始或结束.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function authenticate(&$var)
	{
		$this->lang->load('form_validation', 'chinese');
		//check data format
		if (!($this->_checkDataFormat($result)))
		{
			$var = $result;
			return FALSE;
		}
		else if ($this->input->post('type') == 1)
		{
			$tmpRes = $this->db->query('SELECT * FROM hunter WHERE name = ?', strtolower($this->input->post('userName')));
			if ($tmpRes)
			{
				if ($tmpRes->num_rows() > 0)
				{
					$tmpArr = $tmpRes->first_row('array');
					if ($tmpArr['password'] == strtolower($this->input->post('password')))
					{
						$this->session->set_userdata('userName', strtolower($this->input->post('userName')));
						$this->session->set_userdata('userId', $tmpArr['id']);
						$this->session->set_userdata('type', 'hunter');
						return TRUE;
					}
					else
					{
						//密码错误
						$var = "*密码错误，请仔细检查";
						return FALSE;
					}
				}
				else
				{
					//用户名不存在
					$var = "*无此用户,请重新输入";
					return FALSE;
				}
			}
			else
			{
				//查询失败
				$var = "*系统繁忙，请稍后尝试进入";
				return FALSE;
			}
		}
		else if ($this->input->post('type') == 2)
		{
			$tmpRes = $this->db->query('SELECT * FROM enterpriseUser WHERE name = ?', strtolower($this->input->post('userName')));
			if ($tmpRes)
			{
				if ($tmpRes->num_rows() > 0)
				{
					$tmpArr = $tmpRes->first_row('array');
					if ($tmpArr['password'] == strtolower($this->input->post('password')))
					{
						$this->session->set_userdata('userName', strtolower($this->input->post('userName')));
						$this->session->set_userdata('userId', $tmpArr['id']);
						$this->session->set_userdata('type', 'enterpriseUser');
						return TRUE;
					}
					else
					{
						//密码错误
						$var = "*密码错误，请仔细检查";
						return FALSE;
					}
				}
				else
				{
					//用户名不存在
					$var = "*无此用户,请重新输入";
					return FALSE;
				}
			}
			else
			{
				//查询失败
				$var = "*系统繁忙，请稍后尝试进入";
				return FALSE;
			}
		}
		else
		{
			//错误的用户类型
			$var = "*用户类型不合法";
			return FALSE;
		}
	}

}

/*end*/
