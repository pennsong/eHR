<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<!--{$jqueryHead}-->
		<!--{$validationEngineHead}-->
		<title>更新职位信息</title>
		<style type="text/css" media="screen">
			.locShort {
				width: 35px;
			}
		</style>
		<script>
			$(document).ready(function() {
				$("#jobInfoForm").validationEngine('attach', {
					promptPosition : "centerRight",
					autoPositionUpdate : "true"
				});
				$("#addLanguage").click(function() {
					var ajaxURL = "{cw_ci_site_url param1='jobInfo/addLanguage'}";
					$.ajax({
						url : ajaxURL,
						success : function(data, textStatus, jqXHR) {
							$("#languageSection").append(data);
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="prepend-1 span-62">
				<form id="jobInfoForm" action="{cw_ci_site_url param1='jobInfo/validateUpdate'}" method="post">
					<div class="span-62">
						<input type="hidden" id="job" name="job" value="{$jobInfo['id']}"/>
					</div>
					<div class="span-62">
						<!--{if isset($errorMsg)}-->
						<!--{$errorMsg}-->
						<!--{elseif isset($okMsg)}-->
						<span class="ok1">{$okMsg}</span>
						<!--{/if}-->
					</div>
					<div class="span-62 head3">
						职位介绍
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							职位名称
						</div>
						<div class="span-9">
							<input id="title" name="title" type="text" class="validate[required, custom[onlyNumberLetterChinese]]" value="{$jobInfo['title']}"/>
						</div>
						<div class="span-5 label1">
							招聘人数
						</div>
						<div class="span-9">
							<input id="requireNumber" name="requireNumber" type="text" class="validate[custom[onlyNumberSp]]" value="{$jobInfo['requireNumber']}"/>
						</div>
						<div class="span-5 label1">
							工作性质
						</div>
						<div class="span-9">
							{html_options id=workType name=workType options=$workTypeList selected=$jobInfo['workType']}
						</div>
						<div class="span-7 label1">
							合同性质
						</div>
						<div class="span-9">
							{html_options id=contractType name=contractType options=$contractTypeList selected=$jobInfo['contractType']}
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							工作时间
						</div>
						<div class="span-9">
							{html_options id=workTime name=workTime options=$workTimeList selected=$jobInfo['workTime']}
						</div>
						<div class="span-5 label1">
							招聘城市
						</div>
						<div class="span-9">
							{html_options id=city name=city options=$cityList selected=$jobInfo['city']}
						</div>
						<div class="span-5 label1">
							招聘商圈
						</div>
						<div class="span-9">
							{html_options id=businessArea name=businessArea options=$businessAreaList selected=$jobInfo['businessArea']}
						</div>
						<div class="span-7 label1">
							预计到岗日期
						</div>
						<div class="span-9">
							<input id="onboardDate" name="onboardDate" type="text" class="validate[custom[date]]" value="{$jobInfo['onboardDate']}"/>
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							薪资
						</div>
						<div class="span-9">
							<input id="salaryFrom" name="salaryFrom" type="text" class="validate[custom[onlyNumberSp]]" value="{$jobInfo['salaryFrom']}"/>
						</div>
						<div class="span-5 label1">
							奖金
						</div>
						<div class="span-9">
							<!--{html_checkboxes name='bonus' id='bonus' options=$bonusList selected=$jobBonusList separator='<br />'}-->
						</div>
						<div class="span-5 label1">
							福利
						</div>
						<div class="span-9">
							<!--{html_checkboxes name='welfare' id='welfare' options=$welfareList selected=$jobWelfareList separator='<br />'}-->
						</div>
						<div class="span-7 label1">
							佣金获取日
						</div>
						<div class="span-9">
							{html_options id=commissionDate name=commissionDate options=$commissionDateList selected=$jobInfo['commissionDate']}
						</div>
					</div>
					<div class="span-62 head3">
						职位要求
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							性别
						</div>
						<div class="span-9">
							{html_options id=sex name=sex options=$sexList selected=$jobInfo['sex']}
						</div>
						<div class="span-5 label1">
							年龄
						</div>
						<div class="span-3">
							<input id="ageFrom" name="ageFrom" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$jobInfo['ageFrom']}"/>
						</div>
						<div class="span-2">
							至
						</div>
						<div class="span-3">
							<input id="ageTo" name="ageTo" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$jobInfo['ageTo']}"/>
						</div>
						<div class="prepend-1 span-5 label1">
							身高
						</div>
						<div class="span-3">
							<input id="heightFrom" name="heightFrom" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$jobInfo['heightFrom']}"/>
						</div>
						<div class="span-2">
							至
						</div>
						<div class="span-3">
							<input id="heightTo" name="heightTo" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$jobInfo['heightTo']}"/>
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							学历
						</div>
						<div class="span-9">
							{html_options id=education name=education options=$educationList selected=$jobInfo['education']}
						</div>
					</div>
					<div class="span-62 head3">
						语言
					</div>
					<div id="languageSection">
						<!--{foreach $jobLanguageList as $language=>$commonLevel}-->
						<div class="span-62">
							<div class="span-5">
								{html_options id="language[]" name="language[]" options=$languageList selected=$language}
							</div>
							<div class="span-5 label1">
								掌握能力
							</div>
							<div class="span-5">
								{html_options id="languageLevel[]" name="languageLevel[]" options=$commonLevelList selected=$commonLevel}
							</div>
						</div>
						<!--{/foreach}-->
					</div>
					<div class="span-62">
						<input type="button" id="addLanguage" value="添加" />
					</div>
					<div class="span-62 head3">
						特殊技能
					</div>
					<div class="span-62">
						<textarea id="specialSkill" name="specialSkill" cols="40" rows="5" class="">{$jobInfo['specialSkill']}</textarea>
					</div>
					<div class="span-62 head3">
						工作要求及描述
					</div>
					<div class="span-62">
						<textarea id="detail" name="detail" cols="40" rows="5" class="">{$jobInfo['detail']}</textarea>
					</div>
					<div class="span-5">
						<input type="submit" value="保存" />
					</div>
					<div class="span-5">
						<input type="button" value="重置" />
						<!--only need to reload page-->
					</div>
					<div class="span-5">
						<input type="button" value="返回" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>