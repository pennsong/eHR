<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Upload extends CI_Controller
{
	public function index()
	{
		$errors = array();
		$data = "";
		$success = "false";
		switch($_REQUEST['action'])
		{
			case "upload" :
				//$uploadRoot = "D:\\webroot\\eHR\\upload\\";
				$uploadRoot = "/Library/WebServer/Documents/eHR/upload/";
				$file_temp = $_FILES['file']['tmp_name'];
				date_default_timezone_set('Asia/Shanghai');
				$dateStamp = date("Y_m_d");
				$dateStampFolder = $uploadRoot.$dateStamp;
				if (file_exists($dateStampFolder) && is_dir($dateStampFolder))
				{
				}
				else
				{
					if (mkdir($dateStampFolder))
					{
					}
					else
					{
						$this->_return("创建失败");
					}
				}
				$file_name = $dateStamp."/".$_FILES['file']['name'];
				//complete upload
				$filestatus = move_uploaded_file($file_temp, $uploadRoot.$file_name);
				if (!$filestatus)
				{
					$this->_return("上传失败");
				}
				else
				{
					$subject = $file_name;
					$fileUrl = $file_name;
					//extract hunter name, candidate mobile and candidate name unicode
					$pattern = '/([A-Za-z0-9]{5,8})_([0-9]{11})_((?:![0-9]{1,5}!){2,5})\.(png|flv)/';
					preg_match_all($pattern, $subject, $matches);
					$hunterName = $matches[1][0];
					$tmpRes = $this->db->query("SELECT id FROM hunter WHERE active = 1 AND name = ?", array($hunterName));
					if ($tmpRes->num_rows() > 0)
					{
						$hunter = $tmpRes->first_row()->id;
					}
					else
					{
						$this->_return("此猎头帐户不可用");
					}
					$mobile = $matches[2][0];
					$candiNameCode = $matches[3][0];
					$fileType = $matches[4][0];
					if ($fileType == 'png')
					{
						$infoType = 'talentPhoto';
					}
					else if ($fileType == 'flv')
					{
						$infoType = 'talentVod';
					}
					else
					{
						$infoType = "wrong type";
					}
					//extract candidate name unicode string
					$pattern2 = '/!([0-9]{1,5})!/';
					preg_match_all($pattern2, $candiNameCode, $matches2);
					$strUnicode = "";
					foreach ($matches2[1] as $charCode)
					{
						$strUnicode .= "&#".$charCode.";";
					}
					//convert candidate name's unicode string to real string
					$candiName = mb_convert_encoding($strUnicode, "UTF-8", "HTML-ENTITIES");
					//insert the candidate record into db
					//检查是否已有此人才存在（暂时使用人才名字）
					$tmpRes = $this->db->query("SELECT id FROM talent WHERE hunter = ? AND personName = ?", array(
						$hunter,
						$candiName
					));
					if ($tmpRes->num_rows() > 0)
					{
						//已有记录
						$talent = $tmpRes->first_row()->id;
						if ($infoType == 'talentPhoto')
						{
							$tmpRes = $this->db->query("UPDATE talent SET photoURL = ?, updated = NULL WHERE hunter = ? AND id = ?", array(
								$fileUrl,
								$hunter,
								$talent
							));
						}
						else if ($infoType == 'talentVod')
						{
							$tmpRes = $this->db->query("UPDATE talent SET videoURL = ?, updated = NULL WHERE hunter = ? AND id = ?", array(
								$fileUrl,
								$hunter,
								$talent
							));
						}
						$tmpRes = $this->db->query("SELECT ROW_COUNT() num", array());
						if ($tmpRes->first_row()->num == 1)
						{
							$success = 'true';
						}
					}
					else
					{
						//创建人才
						if ($infoType == 'talentPhoto')
						{
							$tmpRes = $this->db->query("SELECT createTalent(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result", array(
								$hunter,
								$candiName,
								NULL,
								$fileUrl,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								0
							));
						}
						else if ($infoType == 'talentVideo')
						{
							$tmpRes = $this->db->query("SELECT createTalent(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) result", array(
								$hunter,
								$candiName,
								NULL,
								NULL,
								$fileUrl,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								0
							));
						}
						if ($tmpRes->first_row()->result == 1)
						{
							$success = 'true';
						}
					}
					if ($success == 'true')
					{
					}
					else
					{
						$this->_return("数据更新失败");
					}
				}
				break;
			default :
				$this->_return("操作指令错误");
		}
		$this->_return("OK");
	}

	public function checkClientLogin($name, $pass)
	{
		$tmpRes = $this->db->query("SELECT password FROM hunter WHERE name = ?", array($name));
		if ($tmpRes)
		{
			if ($tmpRes->num_rows() == 0)
			{
				$this->_return("用户名不存在");
			}
			else
			{
				$tmpStr = $tmpRes->row()->password;
				if ($tmpStr != $pass)
				{
					$this->_return("密码错误");
				}
				else
				{
					$this->_return("OK");
				}
			}
		}
		else
		{
			$this->_return("数据查询失败");
		}
	}

	private function _return($msg)
	{
		echo "logmsg:".$msg;
		exit ;
	}

	private function _echo_errors($errors)
	{
		for ($i = 0; $i < count($errors); $i++)
		{
			echo("<error>$errors[$i]</error>");
		}
	}

}

/*end*/
