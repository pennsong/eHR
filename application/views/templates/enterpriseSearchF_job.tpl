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
			.locDrawContainer {
				position: relative;
			}
			.locDraw {
				position: absolute;
				background-color: #FF0000;
				left: 490px;
				top: 0px;
				width: 420px;
				height: 500px;
				z-index: 1000;
				padding-left: 10px;
				padding-right: 10px;
				overflow: hidden;
				display: none;
			}
			.locExtend {
				text-decoration: none;
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
				//设置搜索框默认显示文字
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
				//性别
				/*{if isset($smarty.post.sex)}*/
				var curAttr = $(".locSex[idValue={$smarty.post.sex}]").attr('class');
				$(".locSex[idValue={$smarty.post.sex}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//身高
				/*{if isset($smarty.post.height)}*/
				var curAttr = $(".locHeight[idValue={$smarty.post.height}]").attr('class');
				$(".locHeight[idValue={$smarty.post.height}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//学历
				/*{if isset($smarty.post.education)}*/
				var curAttr = $(".locEducation[idValue={$smarty.post.education}]").attr('class');
				$(".locEducation[idValue={$smarty.post.education}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//外表相关
				/*{if isset($smarty.post.appearance)}*/
				var curAttr = $(".locAppearance[idValue={$smarty.post.appearance}]").attr('class');
				$(".locAppearance[idValue={$smarty.post.appearance}]").attr('class', curAttr + ' locSelected');
				/*{/if}*/
				//语言表达相关
				/*{if isset($smarty.post.expression)}*/
				var curAttr = $(".locExpression[idValue={$smarty.post.expression}]").attr('class');
				$(".locExpression[idValue={$smarty.post.expression}]").attr('class', curAttr + ' locSelected');
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
								$(".locBusinessArea").attr('class', 'link2 locBusinessArea');
								//设置选中格式
								var curAttr = $(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class');
								$(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class', curAttr + ' locSelected');
							});
						});
					} else {
						$("#locBusinessArea").html('');
					}
					//清除选中格式
					$(".locCity").attr('class', 'link2 locCity');
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
					$(".locBusinessArea").attr('class', 'link2 locBusinessArea');
					//设置选中格式
					var curAttr = $(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class');
					$(".locBusinessArea[idValue=" + businessAreaId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击性别
				$(".locSex").click(function() {
					var sexId = $(this).attr('idValue');
					//设置搜索条件
					$("#sex").val(sexId);
					//清除选中格式
					$(".locSex").attr('class', 'link2 locSex');
					//设置选中格式
					var curAttr = $(".locSex[idValue=" + sexId + "]").attr('class');
					$(".locSex[idValue=" + sexId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击身高
				$(".locHeight").click(function() {
					var heightId = $(this).attr('idValue');
					var heightFrom = $(this).attr('idValueFrom');
					var heightTo = $(this).attr('idValueTo');
					//设置搜索条件
					$("#height").val(heightId);
					$("#heightFrom").val(heightFrom);
					$("#heightTo").val(heightTo);
					//清除选中格式
					$(".locHeight").attr('class', 'link2 locHeight');
					//设置选中格式
					var curAttr = $(".locHeight[idValue=" + heightId + "]").attr('class');
					$(".locHeight[idValue=" + heightId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击学历
				$(".locEducation").click(function() {
					var educationId = $(this).attr('idValue');
					//设置搜索条件
					$("#education").val(educationId);
					//清除选中格式
					$(".locEducation").attr('class', 'link2 locEducation');
					//设置选中格式
					var curAttr = $(".locEducation[idValue=" + educationId + "]").attr('class');
					$(".locEducation[idValue=" + educationId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击外表相关
				$(".locAppearance").click(function() {
					var appearanceId = $(this).attr('idValue');
					//设置搜索条件
					$("#appearance").val(appearanceId);
					//清除选中格式
					$(".locAppearance").attr('class', 'link2 locAppearance');
					//设置选中格式
					var curAttr = $(".locAppearance[idValue=" + appearanceId + "]").attr('class');
					$(".locAppearance[idValue=" + appearanceId + "]").attr('class', curAttr + ' locSelected');
				});
				//点击语言表达相关
				$(".locExpression").click(function() {
					var expressionId = $(this).attr('idValue');
					//设置搜索条件
					$("#expression").val(expressionId);
					//清除选中格式
					$(".locExpression").attr('class', 'link2 locExpression');
					//设置选中格式
					var curAttr = $(".locExpression[idValue=" + expressionId + "]").attr('class');
					$(".locExpression[idValue=" + expressionId + "]").attr('class', curAttr + ' locSelected');
				});
				//处理分页连接点击事件
				$(".locPage > a").click(function(e) {
					e.preventDefault();
					var url = $(this).attr('href');
					$("#locForm").attr('action', url);
					$("#locForm").submit();
				});
				//处理活动详情div
				$(".locExtend").click(function() {
					var object = $(this);
					if(object.attr('openStatus') == 'open') {
						$(".locDraw").html('');
						$(".locDraw").hide();
						object.html('>');
						object.attr('openStatus', 'close');
					} else if(object.attr('openStatus') == 'close') {
						$(".locExtend").html('>');
						$(".locExtend").attr('openStatus', 'close');
						$(".locDraw").html('');
						$(".locDraw").hide();
						$(".locDraw").load("{cw_ci_site_url param1='enterpriseSearchF_job/getTalentDetailContent'}/" + object.attr('talentId'), function(responseText, textStatus, XMLHttpRequest) {
							if(textStatus == 'success') {
								$(".locDraw").show();
								object.html('<<');
								object.attr('openStatus', 'open');
							}
						});
					}
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
			<form id="locForm" action="{cw_ci_site_url param1='enterpriseSearchF_job/search'}" method="post">
				<div class="prepend-1 span-10">
					<input id="jobId" name="jobId" type="hidden" value="{$jobId}"/>
					<div class="relative">
						<input id="keyWord" name="keyWord" class="locDefaultStrContainer input1" type="text" value="{$smarty.post.keyWord|default:''}" />
						<div class="locDefaultStr defaultStr1 locUserNameDefaultStr">
							请输入搜索内容
						</div>
					</div>
					<input id="city" name="city" type="hidden" value="{$smarty.post.city|default:''}" />
					<input id="businessArea" name="businessArea" type="hidden" value="{$smarty.post.businessArea|default:''}" />
					<input id="sex" name="sex" type="hidden" value="{$smarty.post.sex|default:''}" />
					<input id="ageFrom" name="ageFrom" type="hidden" value="{$smarty.post.ageFrom|default:''}" />
					<input id="ageTo" name="ageTo" type="hidden" value="{$smarty.post.ageTo|default:''}" />
					<input id="height" name="height" type="hidden" value="{$smarty.post.height|default:''}" />
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
				<a href="{cw_ci_site_url param1='enterpriseMain'}">返回首页</a>
			</div>
			<div class="clear prepend-1 span-62 prepend-top">
				<div class="span-62">
					<div class="span-8">
						<span class="label1">城市</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locCity" idValue="">不限</a>
						<!--{foreach $cityList as $city}-->
						<a href="#" class="link2 locCity" idValue="{$city['id']}">{$city['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">商圈</span>
					</div>
					<div id="locBusinessArea" class="span-54">
						<!--{if isset($businessAreaList)}-->
						<a href="#" class="link2 locBusinessArea" idValue="">不限</a>
						<!--{foreach $businessAreaList as $businessArea}-->
						<a href="#" class="link2 locBusinessArea" idValue="{$businessArea['id']}">{$businessArea['name']}</a>
						<!--{/foreach}-->
						<!--{/if}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">性别</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locSex" idValue="">不限</a>
						<!--{foreach $sexList as $sex}-->
						<a href="#" class="link2 locSex" idValue="{$sex['id']}">{$sex['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">身高</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locHeight" idValue="" idValueFrom="" idValueTo="">不限</a>
						<!--{foreach $heightList as $key=>$value}-->
						<a href="#" class="link2 locHeight" idValue="{$key}" idValueFrom="{$value[1]}" idValueTo="{$value[2]}">{$value[0]}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">学历</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locEducation" idValue="">不限</a>
						<!--{foreach $educationList as $education}-->
						<a href="#" class="link2 locEducation" idValue="{$education['id']}">{$education['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">外表相关</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locAppearance" idValue="">不限</a>
						<!--{foreach $appearanceList as $appearance}-->
						<a href="#" class="link2 locAppearance" idValue="{$appearance['id']}">{$appearance['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-8">
						<span class="label1">语言表达相关</span>
					</div>
					<div class="span-54">
						<a href="#" class="link2 locExpression" idValue="">不限</a>
						<!--{foreach $expressionList as $expression}-->
						<a href="#" class="link2 locExpression" idValue="{$expression['id']}">{$expression['name']}</a>
						<!--{/foreach}-->
					</div>
				</div>
				<div class="span-62">
					<div class="span-32">
						<div class="locDrawContainer">
							<div class="locDraw"></div>
						</div>
						<!--{foreach $talentList as $talent}-->
						<div class="span-31">
							<div class="span-31">
								<div class="span-5 head3">
									{$talent['talentPersonName']}
								</div>
								<div class="span-3 label1">
									备注:
								</div>
								<div class="span-5 text1">
									{$talent['hunterNote']|truncate:6}
								</div>
								<div class="span-3 label1">
									城市:
								</div>
								<div class="span-5 text1">
									{$talent['cityList']|truncate:8}
								</div>
								<div class="span-3 label1">
									商区:
								</div>
								<div class="span-5 text1">
									{$talent['businessAreaList']|truncate:8}
								</div>
							</div>
							<div class="span-31">
								<div class="span-5 label1">
									推荐人:
								</div>
								<div class="span-8 text1">
									{$talent['hunterAccountName']|truncate:15}
								</div>
								<div class="span-3 label1">
									性别:
								</div>
								<div class="span-5 text1">
									{$talent['sex']}
								</div>
								<div class="span-3 label1">
									学历:
								</div>
								<div class="span-5 text1">
									{$talent['education']}
								</div>
							</div>
						</div>
						<div class="span-1">
							<a href="#" class="locExtend" talentId="{$talent['id']}" openStatus="close">&gt;</a>
						</div>
						<hr />
						<!--{/foreach}-->
						{cw_ci_create_links}
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
