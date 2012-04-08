<?php
/**
 * customized Controller to check login status
 * @author: penn
 */
class CW_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!CW_Controller::_checkLogin())
		{
			redirect(base_url() . "index.php/login");
		}
	}

	public function _checkLogin()
	{
		if ($this->session->userdata('userName') && $this->session->userdata('type'))
		{
			if ($this->session->userdata('type') == 'hunter')
			{
				$tmpRes = $this->db->query("SELECT * FROM hunter WHERE status=1 AND name='{$this->session->userdata('userAccount')}';");
				if ($tmpRes && $tmpRes->num_rows > 0)
				{
					return TRUE;
				}
			}
			else if ($this->session->userdata('type') == 'hr')
			{
				$tmpRes = $this->db->query("SELECT * FROM enterpriseUser WHERE status=1 AND name='{$this->session->userdata('userAccount')}';");
				if ($tmpRes && $tmpRes->num_rows > 0)
				{
					return TRUE;
				}
			}
		}
		return FALSE;
	}

}

/*end file CW_Controller.php*/
