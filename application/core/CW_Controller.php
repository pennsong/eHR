<?php
/**
 * customized Controller to check login status
 * @author: penn
 */
class CW_Controller extends CI_Controller
{
	private $commonHead = '';
	private $jqueryHead = '';
	private $validationEngineHead = '';
	public function __construct()
	{
		parent::__construct();
		//define common head for each page
		$this->commonHead .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'."\n";
		$this->commonHead .= '<!-- Framework CSS -->'."\n";
		$this->commonHead .= '<link rel="stylesheet" href="'.base_url().'resource/css/screen.css" type="text/css" media="screen, projection"/>'."\n";
		$this->commonHead .= '<link rel="stylesheet" href="'.base_url().'resource/css/print.css" type="text/css" media="print"/>'."\n";
		$this->commonHead .= '<!--[if lt IE 8]><link rel="stylesheet" href="{cw_ci_base_url}resource/css/ie.css" type="text/css" media="screen, projection"/><![endif]-->'."\n";
		$this->commonHead .= '<link rel="stylesheet" href="'.base_url().'resource/css/user.css" type="text/css" media="screen, projection"/>'."\n";
		$this->smarty->assign('commonHead', $this->commonHead);
		$this->jqueryHead .= '<!-- jquery -->'."\n";
		$this->jqueryHead .= '<script src="'.base_url().'resource/js/jquery.js" type="text/javascript"></script>'."\n";
		$this->smarty->assign('jqueryHead', $this->jqueryHead);
		$this->validationEngineHead .= '<!-- validationEngine -->'."\n";
		$this->validationEngineHead .= '<link rel="stylesheet" href="'.base_url().'resource/css/template.css" type="text/css" media="screen, projection"/>'."\n";
		$this->validationEngineHead .= '<link rel="stylesheet" href="'.base_url().'resource/css/validationEngine.jquery.css" type="text/css" media="screen, projection"/>'."\n";
		$this->validationEngineHead .= '<script src="'.base_url().'resource/js/jquery.validationEngine.js" type="text/javascript"></script>'."\n";
		$this->validationEngineHead .= '<script src="'.base_url().'resource/js/jquery.validationEngine-zh_CN.js" type="text/javascript"></script>'."\n";
		$this->smarty->assign('validationEngineHead', $this->validationEngineHead);
		if (!CW_Controller::_checkLogin())
		{
			redirect(base_url()."index.php/login");
		}
	}

	public function _checkLogin()
	{
		if ($this->uri->segment(1) == 'login')
		{
			return TRUE;
		}
		else if ($this->session->userdata('userName') && $this->session->userdata('type'))
		{
			if ($this->session->userdata('type') == 'hunter')
			{
				$tmpRes = $this->db->query("SELECT * FROM hunter WHERE active=1 AND name='{$this->session->userdata('userName')}';");
				if ($tmpRes && $tmpRes->num_rows > 0)
				{
					return TRUE;
				}
			}
			else if ($this->session->userdata('type') == 'enterpriseUser')
			{
				$tmpRes = $this->db->query("SELECT * FROM enterpriseUser WHERE active=1 AND name='{$this->session->userdata('userName')}';");
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
