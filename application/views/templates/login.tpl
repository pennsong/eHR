<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<!-- Framework CSS -->
		<link rel="stylesheet" href="{cw_ci_base_url}resource/css/screen.css" type="text/css" media="screen, projection"/>
		<link rel="stylesheet" href="{cw_ci_base_url}resource/css/print.css" type="text/css" media="print"/>
		<!--[if lt IE 8]><link rel="stylesheet" href="{cw_ci_base_url}resource/css/ie.css" type="text/css" media="screen, projection"/><![endif]-->
		<link rel="stylesheet" href="{cw_ci_base_url}resource/css/user.css" type="text/css" media="screen, projection"/>
		<!-- jquery -->
		<script src="{cw_ci_base_url}resource/js/jquery.js" type="text/javascript"></script>
		<!--validationEngine-->
		<link rel="stylesheet" href="{cw_ci_base_url}resource/css/template.css" type="text/css" media="screen, projection"/>
		<link rel="stylesheet" href="{cw_ci_base_url}resource/css/validationEngine.jquery.css" type="text/css" media="screen, projection"/>
		<script src="{cw_ci_base_url}resource/js/jquery.validationEngine.js" type="text/javascript"></script>
		<script src="{cw_ci_base_url}resource/js/jquery.validationEngine-zh_CN.js" type="text/javascript"></script>
		<title>登录</title>
		<style type="text/css" media="screen">
			img.locLogo {
				height: 30px;
			}
			div.locUserNameDefaultStr {
				left: 2px;
			}
			div.locGeneralErrorInfo {
				padding-top: 7px;
				padding-bottom: 7px;
				height: 14px;
			}
			div.locUserType {
				height: 19px;
			}
		</style>
		<script>
			$(document).ready(function() {
				$(".locDefaultStr").click(function() {
					$(this).prev(".locDefaultStrContainer").focus();
				});
				$(".locDefaultStrContainer").focus(function() {
					$(this).next(".locDefaultStr").hide();
				});
				$(".locDefaultStrContainer").blur(function() {
					if($(this).val() == "") {
						$(this).next(".locDefaultStr").show();
					}
				});
				$(".locDefaultStrContainer").blur();
				$("#locLoginForm").validationEngine();
			});
			function checkUserName(field, rules, i, options) {
				var err = new Array();
				var reg1 = /^[_\.].*/;
				var reg2 = /.*[_\.]$/;
				var str = field.val();
				if(reg1.test(str) || reg2.test(str)) {
					err.push('* 不能以下划线或点开始或结束！');
				}
				if((countOccurrences(str, '.') + countOccurrences(str, '_')) > 1) {
					err.push('* 一个用户名仅允许包含一个下划线或一个点！');
				}
				if(err.length > 0) {
					return err.join("<br>");
				}
			}

			function countOccurrences(str, character) {
				var i = 0;
				var count = 0;
				for( i = 0; i < str.length; i++) {
					if(str.charAt(i) == character) {
						count++;
					}
				}
				return count;
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="span-64 last">
				  <img class="locLogo" src="{cw_ci_base_url}resource/img/logo.png"/>
			</div>
			<div class="clear prepend-19 last append-bottom20">
				<div class="head1">
					欢迎来到E-hiring
				</div>
			</div>
			<form id="locLoginForm" action="{cw_ci_site_url param1='login/submit_validate'}" method="post">
				<div class="clear prepend-19 append-bottom5">
					<div class="label1">
						用户名
					</div>
				</div>
				<div class="clear prepend-19 span-11 inline append-bottom10">
					<div class="relative">
						<input id="userName" name="userName" class="locDefaultStrContainer input1 validate[required, custom[onlyLetterNumberUnderLineDot], minSize[6], maxSize[15], funcCall[checkUserName]]" value="{$smarty.post.userName|default:''}" type="text" />
						<div class="locDefaultStr defaultStr1 locUserNameDefaultStr">
							请输入用户名
						</div>
					</div>
				</div>
				<div class="clear prepend-19 append-bottom5">
					<div class="label1">
						密码
					</div>
				</div>
				<div class="clear prepend-19 span-11 inline append-bottom20">
					<div class="relative">
						<input id="password" name="password" class="locDefaultStrContainer input1 validate[required, custom[onlyLetterNumber], minSize[6], maxSize[20]]" type="password" />
						<div class="locDefaultStr defaultStr1 locUserNameDefaultStr">
							请输入密码
						</div>
					</div>
				</div>
				<div class="clear prepend-19 append-bottom5">
					<div class="label1">
						请选择您的身份
					</div>
				</div>
				<div class="clear prepend-19 append-bottom20 locUserType">
					{html_radios name='type' values=$typeId output=$typeName selected=$smarty.post.type|default:1}
				</div>
				<div class="clear prepend-19">
					<div class="inline span-7">
						<button id="loginButton" class="button1" type="submit">
							进入E-hiring
						</button>
					</div>
					<div class="span-10 locGeneralErrorInfo">
						<div class="error1">
							 {$loginErrorInfo|default:''}
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>