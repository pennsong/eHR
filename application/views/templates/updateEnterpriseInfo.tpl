<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<!--{$jqueryHead}-->
		<!--{$validationEngineHead}-->
		<title>更新公司信息</title>
		<style type="text/css" media="screen">
			.locContainer {
				width: 450px;
			}
		</style>
		<script>
			$(document).ready(function() {
				$("#enterpriseInfoForm").validationEngine();
			});
		</script>
	</head>
	<body>
		<div class="container locContainer">
			<div class="span-30">
				<form id="enterpriseInfoForm" action="{cw_ci_site_url param1='updateEnterpriseInfo/submit_validate'}" method="post">
					<div class="span-30">
						<input type="hidden" id="enterprise" name="enterprise" value="{$enterpriseInfo['id']}"/>
					</div>
					<div class="span-30">
						<!--{if isset($errorMsg)}-->
						<!--{$errorMsg}-->
						<!--{elseif isset($okMsg)}-->
						<span class="ok1">{$okMsg}</span>
						<!--{/if}-->
					</div>
					<div class="span-4">
						公司名称
					</div>
					<div class="span-26">
						<input id="name" name="name" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$enterpriseInfo['name']}"/>
					</div>
					<div class="span-4">
						电话
					</div>
					<div class="span-26">
						<input id="phone" name="phone" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$enterpriseInfo['phone']}"/>
					</div>
					<div class="span-4">
						邮件
					</div>
					<div class="span-26">
						<input id="mail" name="mail" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$enterpriseInfo['mail']}"/>
					</div>
					<div class="span-4">
						地址
					</div>
					<div class="span-26">
						<input id="address" name="address" type="text" class="validate[required, custom[onlyNumberLetterChinese]" value="{$enterpriseInfo['address']}"/>
					</div>
					<div class="span-4">
						简介
					</div>
					<div class="span-26">
						<textarea id="introduction" name="introduction" cols="40" rows="5" class="validate[required, custom[onlyNumberLetterChinese]">{$enterpriseInfo['introduction']}</textarea>
					</div>
					<div class="span-4">
						<input type="submit" value="保存"/>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>