<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<!--{$jqueryHead}-->
		<title>公司职位挑选人才</title>
		<style type="text/css" media="screen">
			.locSelected {
				background: yellow;
			}
		</style>
		<script>
			function openWindow() {
				var browser = navigator.appName;
				if(browser == "Microsoft Internet Explorer") {
					window.opener = self;
				}
				window.open("{cw_ci_site_url param1='enterpriseInfo/index'}", 'null', 'width=550,height=480,toolbar=no,scrollbars=no,location=no,resizable=no');
			}


			$(document).ready(function() {
				//设置选中状态
				//城市
				/*{if isset($smarty.post.city)}*/
				var curAttr = $(".locCity[idValue={$smarty.post.city}]").attr('class');
				$(".locCity[idValue={$smarty.post.city}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//商区
				/*{if isset($smarty.post.businessArea)}*/
				var curAttr = $(".locBusinessArea[idValue={$smarty.post.businessArea}]").attr('class');
				$(".locBusinessArea[idValue={$smarty.post.businessArea}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//点击城市
				$(".locCity").click(function() {
					var cityId = $(this).attr('idValue');
					//设置搜索条件
					$("#city").val(cityId);
					$("#businessArea").val('');
					//取得对应商圈
					if(cityId != 0) {
						$("#locBusinessArea").load('{$businessAreaListURL}/' + cityId, function() {
							//默认选择不限商圈
							$("#businessArea").val('');
							var curAttr = $(".locBusinessArea[idValue='']").attr('class');
							$(".locBusinessArea[idValue='']").attr('class', curAttr + ' locSelected');
							//重新设置点击商圈
							$(".locBusinessArea").click(function() {
								var businessAreaId = $(this).attr('idValue');
								//设置搜索条件
								$("#businessArea").val(businessAreaId);
								//清除选中格式
								$(".locBusinessArea").attr('class', 'locItem locBusinessArea');
								//设置选中格式
								var curAttr = $(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class');
								$(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class', curAttr + ' locSelected');
							});
						});
					} else {
						$("#locBusinessArea").html('');
					}
					//清除选中格式
					$(".locCity").attr('class', 'locItem locCity');
					//设置选中格式
					var curAttr = $(".locCity[idValue=" + cityId + "]").attr('class');
					$(".locCity[idValue=" + cityId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击商区
				$(".locBusinessArea").click(function() {
					var businessAreaId = $(this).attr('idValue');
					//设置搜索条件
					$("#businessArea").val(businessAreaId);
					//清除选中格式
					$(".locBusinessArea").attr('class', 'locItem locBusinessArea');
					//设置选中格式
					var curAttr = $(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class');
					$(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class', curAttr + ' locSelected');
				});
			});
		</script>
	</head>
	<body>
		<div class="container ">
			<div class="span-64 last">
				<div class="span-49">
					<img class="" src="{cw_ci_base_url}resource/img/logo.png"/>
				</div>
				<div class="span-12">
					<a href="#" onclick="openWindow()">欢迎您,公司用户:{$userName}</a>
				</div>
				<div class="span-3">
					<a href="{cw_ci_site_url param1='login/logout'}">退出</a>
				</div>
			</div>
			<form action="{cw_ci_site_url param1='enterpriseSearchF_job/search'}" method="post">
				<div class="prepend-1 span-10">
					<input id="jobId" name="jobId" type="hidden" value="{$jobId}"/>
					<input id="keyWord" name="keyWord" type="text" value="{$smarty.post.keyWord|default:''}" />
					<input id="city" name="city" type="hidden" value="{$smarty.post.city|default:''}" />
					<input id="businessArea" name="businessArea" type="hidden" value="{$smarty.post.businessArea|default:''}" />
					<input id="sex" name="sex" type="hidden" value="{$smarty.post.sex|default:''}" />
					<input id="ageFrom" name="ageFrom" type="hidden" value="{$smarty.post.ageFrom|default:''}" />
					<input id="ageTo" name="ageTo" type="hidden" value="{$smarty.post.ageTo|default:''}" />
					<input id="heightFrom" name="heightFrom" type="hidden" value="{$smarty.post.heightFrom|default:''}" />
					<input id="heightTo" name="heightTo" type="hidden" value="{$smarty.post.heightTo|default:''}" />
					<input id="education" name="education" type="hidden" value="{$smarty.post.education|default:''}" />
					<input id="appearance" name="appearance" type="hidden" value="{$smarty.post.appearance|default:''}" />
					<input id="expression" name="expression" type="hidden" value="{$smarty.post.expression|default:''}" />
				</div>
				<div class="span-4">
					<input type="submit" value="搜索" />
				</div>
			</form>
			<div class="span-10">
				<a href="#">返回首页</a>
			</div>
			<div class="clear prepend-1 span-62 prepend-top">
				<div class="span-62">
					<div class="span-8">
						<span class="label1">城市</span>
					</div>
					<div class="span-54">
						<a href="#" class="locItem locCity" idValue="">不限</a>
						<!--{foreach $cityList as $city}-->
						<a href="#" class="locItem locCity" idValue="{$city['id']}">{$city['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">商圈</span>
					</div>
					<div id="locBusinessArea" class="span-54">
						<!--{if isset($businessAreaList)}-->
						<a href="#" class="locItem locBusinessArea" idValue="">不限</a>
						<!--{foreach $businessAreaList as $businessArea}-->
						<a href="#" class="locItem locBusinessArea" idValue="{$businessArea['id']}">{$businessArea['name']}</a>
						<!--{/foreach}-->
						<!--{/if}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">性别</span>
					</div>
					<div class="span-54">
						<span class="locItem locSex" idValue="">不限</span>
						<!--{foreach $sexList as $sex}-->
						<span class="locItem locSex" idValue="{$sex['id']}">{$sex['name']}</span>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">身高</span>
					</div>
					<div class="span-54">
						<span class="locItem locHeight" idValue="">不限</span>
						<!--{foreach $heightList as $key=>$value}-->
						<span class="locItem locHeight" idValue="{$key}">{$value}</span>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">学历</span>
					</div>
					<div class="span-54">
						<span class="locItem locEducation" idValue="">不限</span>
						<!--{foreach $educationList as $education}-->
						<span class="locItem locEducation" idValue="{$education['id']}">{$education['name']}</span>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">外表相关</span>
					</div>
					<div class="span-54">
						<span class="locItem locAppearance" idValue="">不限</span>
						<!--{foreach $appearanceList as $appearance}-->
						<span class="locItem locAppearance" idValue="{$appearance['id']}">{$appearance['name']}</span>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">语言表达相关</span>
					</div>
					<div class="span-54">
						<span class="locItem locExpression" idValue="">不限</span>
						<!--{foreach $expressionList as $expression}-->
						<span class="locItem locExpression" idValue="{$expression['id']}">{$expression['name']}</span>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-31">
						<!--{foreach $talentList as $talent}-->
						<!--{foreach $talent as $item}-->
						<span>{$item}</span>
						<!--{/foreach}-->
						<hr>
						<!--{/foreach}-->
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
