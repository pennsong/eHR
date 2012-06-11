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
				$("#jobInfoFormDDD").validationEngine('attach', {
					promptPosition : "centerRight",
					autoPositionUpdate : "true"
				});
				$("#addLanguage").click(function() {
					var ajaxURL = "{site_url('jobInfo/addLanguage')}";
					$.ajax({
						url : ajaxURL,
						success : function(data, textStatus, jqXHR) {
							$("#languageSection").append(data);
						}
					});
				});
				//设置重置按钮
				$("#resetButton").click(function() {
					window.location.href = "{site_url('jobInfo/index')}" + "/" + "{$smarty.post.job}";
				});
				var tmpCity = /*{$smarty.post.city|default:'null'}*/+'';
				var tmpBusinessArea = /*{$smarty.post.businessArea|default:'null'}*/+'';
				reflashCityBusinessArea(tmpCity, tmpBusinessArea);
			});
			function reflashCityBusinessArea(city, businessArea) {
				var ajaxURL = "{site_url('jobInfo/setCityBusinessArea')}/" + city + '/' + businessArea;
				$("#cityBusinessSection").load(ajaxURL, function(responseText, textStatus, XMLHttpRequest) {
					if(textStatus == 'success') {
						$("#city").change(function() {
							var vCity = $("#city").val();
							if(vCity == '') {
								vCity = 'null';
							}
							reflashCityBusinessArea(vCity, 'null');
						});
					}
				});
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="prepend-1 span-62">
				<form id="jobInfoForm" action="{site_url('jobInfo/validateUpdate')}" method="post">
					<div class="span-62">
						<input type="hidden" id="job" name="job" value="{$smarty.post.job}"/>
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
							<input id="title" name="title" type="text" class="validate[required, custom[onlyNumberLetterChinese]]" value="{$smarty.post.title}"/>
						</div>
						<div class="span-5 label1">
							招聘人数
						</div>
						<div class="span-9">
							<input id="requireNumber" name="requireNumber" type="text" class="validate[custom[onlyNumberSp]]" value="{$smarty.post.requireNumber}"/>
						</div>
						<div class="span-5 label1">
							工作性质
						</div>
						<div class="span-9">
							{html_options id=workType name=workType options=$workTypeList selected=$smarty.post.workType}
						</div>
						<div class="span-7 label1">
							合同性质
						</div>
						<div class="span-9">
							{html_options id=contractType name=contractType options=$contractTypeList selected=$smarty.post.contractType}
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							工作时间
						</div>
						<div class="span-9">
							{html_options id=workTime name=workTime options=$workTimeList selected=$smarty.post.workTime}
						</div>
						<div id="cityBusinessSection"></div>
						<div class="span-7 label1">
							预计到岗日期
						</div>
						<div class="span-9">
							<input id="onboardDate" name="onboardDate" type="text" class="validate[custom[date]]" value="{$smarty.post.onboardDate}"/>
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							薪资
						</div>
						<div class="span-9">
							<input id="salaryFrom" name="salaryFrom" type="text" class="validate[custom[onlyNumberSp]]" value="{$smarty.post.salaryFrom}"/>
						</div>
						<div class="span-5 label1">
							奖金
						</div>
						<div class="span-9">
							<!--{html_checkboxes name='bonusList' id='bonusList[]' options=$bonusList selected=$smarty.post.bonusList|default:'' separator='<br />'}-->
						</div>
						<div class="span-5 label1">
							福利
						</div>
						<div class="span-9">
							<!--{html_checkboxes name='welfareList' id='welfareList[]' options=$welfareList selected=$smarty.post.welfareList|default:'' separator='<br />'}-->
						</div>
						<div class="span-7 label1">
							佣金获取日
						</div>
						<div class="span-9">
							{html_options id=commissionDate name=commissionDate options=$commissionDateList selected=$smarty.post.commissionDate}
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
							{html_options id=sex name=sex options=$sexList selected=$smarty.post.sex}
						</div>
						<div class="span-5 label1">
							年龄
						</div>
						<div class="span-3">
							<input id="ageFrom" name="ageFrom" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$smarty.post.ageFrom}"/>
						</div>
						<div class="span-2">
							至
						</div>
						<div class="span-3">
							<input id="ageTo" name="ageTo" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$smarty.post.ageTo}"/>
						</div>
						<div class="prepend-1 span-5 label1">
							身高
						</div>
						<div class="span-3">
							<input id="heightFrom" name="heightFrom" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$smarty.post.heightFrom}"/>
						</div>
						<div class="span-2">
							至
						</div>
						<div class="span-3">
							<input id="heightTo" name="heightTo" type="text" class="locShort validate[custom[onlyNumberSp]]" value="{$smarty.post.heightTo}"/>
						</div>
					</div>
					<div class="span-62">
						<div class="span-5 label1">
							学历
						</div>
						<div class="span-9">
							{html_options id=education name=education options=$educationList selected=$smarty.post.education}
						</div>
					</div>
					<div class="span-62 head3">
						语言
					</div>
					<div id="languageSection">
						<!--{if isset($smarty.post.languageList)}-->
						<!--{foreach $smarty.post.languageList as $language}-->
						<div class="span-62">
							<div class="span-5">
								{html_options id="languageList[]" name="languageList[]" options=$languageList selected=$language}
							</div>
							<div class="span-5 label1">
								掌握能力
							</div>
							<div class="span-5">
								{html_options id="languageLevelList[]" name="languageLevelList[]" options=$commonLevelList selected=$smarty.post.languageLevelList[$language@index]}
							</div>
						</div>
						<!--{/foreach}-->
						<!--{/if}-->
					</div>
					<div class="span-62">
						<input type="button" id="addLanguage" value="添加" />
					</div>
					<div class="span-62 head3">
						特殊技能
					</div>
					<div class="span-62">
						<textarea id="specialSkill" name="specialSkill" cols="40" rows="5" class="">{$smarty.post.specialSkill}</textarea>
					</div>
					<div class="span-62 head3">
						工作要求及描述
					</div>
					<div class="span-62">
						<textarea id="detail" name="detail" cols="40" rows="5" class="">{$smarty.post.detail}</textarea>
					</div>
					<div class="span-5">
						<input type="submit" value="保存" />
					</div>
					<div class="span-5">
						<input id="resetButton" type="button" value="重置" />
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