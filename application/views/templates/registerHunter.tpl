<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<!--{$jqueryHead}-->
		<!--{$validationEngineHead}-->
		<title>注册小猎头</title>
		<style type="text/css" media="screen"></style>
		<script>
			$(document).ready(function() {
				$("#locHunterRegisterForm").validationEngine('attach', {
					promptPosition : "centerRight",
					autoPositionUpdate : "true"
				});
			});
			function checkMobile(field, rules, i, options) {
				var err = new Array();
				var reg1 = /^1[3581].*$/;
				var str = field.val();
				if(!reg1.test(str)) {
					err.push('*手机号码填写错误，请重新填写');
				}
				if(err.length > 0) {
					return err.join("<br>");
				}
			}

			//数字判断函数IsNumeric()
			function IsNumeric(oNum) {
				var reg1 = /^[0-9].*$/;
				if(reg1.test(oNum)) {
					return true;
				} else {
					return false;
				}
			}

			function checkIdN2(field, rules, i, options) {
			}

			function checkIdNo(field, rules, i, options) {
				var err = new Array();
				var StrNumber = field.val();
				//判断身份证号码格式函数
				//公民身份号码是特征组合码，
				//排列顺序从左至右依次为：六位数字地址码，八位数字出生日期码，三位数字顺序码和一位数字校验码
				//身份证号码长度判断
				//身份证号码长度判断
				if(StrNumber.length < 15 || StrNumber.length == 16 || StrNumber.length == 17 || StrNumber.length > 18) {
					err.push('*填写的身份证号码长度不正确');
				} else {
					//身份证号码最后一位可能是超过100岁老年人的X.X也可以代表是阿拉伯数字10的意思
					//所以排除掉最后一位数字进行数字格式测试，最后一位数字有最后一位数字的算法
					var Ai;
					if(StrNumber.length == 18) {
						Ai = StrNumber.substring(0, 17);
					} else {
						Ai = StrNumber.substring(0, 6) + '19' + StrNumber.substring(6, 9);
					}
					//调用数字判断函数IsNumeric()
					if(IsNumeric(Ai) == false) {
						err.push('*身份证号码数字字符串不正确');
					} else {
						var arrVerifyCode = new Array('1', '0', 'x', '9', '8', '7', '6', '5', '4', '3', '2');
						var Wi = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
						var k, TotalmulAiWi = 0;
						for( k = 0; k < 17; k++) {
							TotalmulAiWi = TotalmulAiWi + parseInt(Ai.substr(k, 1)) * Wi[k];
						}
						var modValue = TotalmulAiWi % 11;
						var strVerifyCode = arrVerifyCode[modValue];
						Ai = Ai + strVerifyCode;
						if((StrNumber.length == 18) && (StrNumber != Ai)) {
							err.push('*填写的身份证号码有误');
						}
					}
				}
				if(err.length > 0) {
					return err.join("<br>");
				}
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="span-64 last">
				  <img class="logo" src="{base_url()}resource/img/logo.png"/>
			</div>
			<div class="prepend-1 span-62">
				<form id="locHunterRegisterForm" action="{site_url('hunterInfo/noLogin_validateRegister')}" method="post">
					<div class="span-62">
						<!--{if isset($errorMsg)}-->
						<!--{$errorMsg}-->
						<!--{elseif isset($okMsg)}-->
						<span class="ok1">{$okMsg}</span>
						<!--{/if}-->
					</div>
					<div class="span-7 label1">
						用户名
					</div>
					<div class="span-55">
						<input id="name" name="name" type="text" class="validate[required, custom[onlyLetterNumber, minSize[6], maxSize[14]]" value="{$hunterInfo['name']|default:''}"/>
					</div>
					<div class="span-7 label1">
						密码
					</div>
					<div class="span-55">
						<input id="password" name="password" type="text" class="validate[required, custom[onlyLetterNumber, minSize[6], maxSize[14]]" value="{$hunterInfo['password']|default:''}"/>
					</div>
					<div class="span-7 label1">
						确认密码
					</div>
					<div class="span-55">
						<input id="passwordConfirm" name="passwordConfirm" type="text" class="validate[required, equals[password]" value="{$hunterInfo['passwordConfirm']|default:''}"/>
					</div>
					<div class="span-7 label1">
						座机
					</div>
					<div class="span-55">
						<input id="fixphone1" name="fixphone1" type="text" class="validate[required, custom[onlyNumberSp]" value="{$hunterInfo['fixphone1']|default:''}"/>
						-
						<input id="fixphone2" name="fixphone2" type="text" class="validate[required, custom[onlyNumberSp]" value="{$hunterInfo['fixphone2']|default:''}"/>
						-
						<input id="fixphone3" name="fixphone3" type="text" class="validate[required, custom[onlyNumberSp]" value="{$hunterInfo['fixphone3']|default:''}"/>
					</div>
					<div class="span-7 label1">
						手机号
					</div>
					<div class="span-55">
						<input id="mobile" name="mobile" type="text" class="validate[required, custom[onlyNumberSp], minSize[11], maxSize[11], funcCall[checkMobile]]" value="{$hunterInfo['mobile']|default:''}"/>
					</div>
					<div class="span-7 label1">
						姓名
					</div>
					<div class="span-55">
						<input id="personName" name="personName" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$hunterInfo['personName']|default:''}"/>
					</div>
					<div class="span-7 label1">
						身份证号码
					</div>
					<div class="span-55">
						<input id="idNo" name="idNo" type="text" class="validate[required, funcCall[checkIdNo]]" value="{$hunterInfo['idNo']|default:''}"/>
					</div>
					<div class="span-7 label1">
						常用地址
					</div>
					<div class="span-55">
						<input id="address" name="address" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$hunterInfo['address']|default:''}"/>
					</div>
					<div class="span-7 label1">
						银行卡帐号
					</div>
					<div class="span-55">
						<input id="bankNo" name="bankNo" type="text" class="validate[required, custom[onlyNumberSp]" value="{$hunterInfo['bankNo']|default:''}"/>
					</div>
					<div class="span-7 label1">
						银行卡开户行
					</div>
					<div class="span-55">
						<input id="bankName" name="bankName" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$hunterInfo['bankName']|default:''}"/>
					</div>
					<div class="span-6">
						<input type="submit" value="保存"/>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>