<!--{extends file='enterprisePage.tpl'}-->
<!--{block name=title}-->
<title>人才详细信息</title>
<!--{/block}-->
<!--{block name=subScript}-->
<!--{$flowplayerHead}-->
<script>
	$(document).ready(function() {
		$("#saveButton").click(function() {
			$("#msg").load("{site_url('enterpriseSearchF_job/updateDealInfo')}/{$jobId}/{$talentInfo['id']}" + "/" + encodeURIComponent($("#enterpriseNote").val()), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
				}
			});
		});
		//获得对应猎头成功推荐人数
		$("#locSuccessNum").load("{site_url('enterpriseSearchF_job/getHunterSuccessNum')}/{$talentInfo['hunter']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//获得对应猎头积分
		$("#locPoint").load("{site_url('enterpriseSearchF_job/getHunterPoint')}/{$talentInfo['hunter']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//获得交易历史
		$("#historySection").load("{site_url('enterpriseSearchF_job/getDealHistory')}/{$talentInfo['id']}/{$jobId}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//设置按钮
		$("#locButtonLayout").load("{site_url('enterpriseSearchF_job/getButtonLayout')}/{$jobId}/{$talentInfo['id']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//设置视频
		flowplayer("locPlayer", "{base_url()}resource/flowplayer/flowplayer-3.2.7.swf", {
			clip : {
				autoPlay : false,
				autoBuffering : true
			}
		});
	}); 
</script>
<!--{/block}-->
<!--{block name=subBody}-->
<div class="span-60">
	<div class="span-5">
		<a href="{site_url('enterpriseManageList/index/')}/{$jobId}">返回上一级</a>
	</div>
</div>
<div class="span-28">
	<div class="span-28">
		<input id="jobId" type="hidden" value="{$jobId}" />
		<div class="span-5">
			{$talentInfo['talentPersonName']}
		</div>
		<div class="span-5">
			<span class="label1">推荐人:</span>
		</div>
		<div class="span-18">
			<div class="span-18">
				<input id="talent" type="hidden" value="{$talentInfo['id']}" />
				<span class="text1">{$talentInfo['talentPersonName']}</span>
			</div>
			<div class="span-18">
				<div class="span-5">
					<span class="label1">已推荐:</span>
				</div>
				<div id="locSuccessNum" class="span-13">
					<img src="{base_url()}/resource/img/loader.gif" />
				</div>
			</div>
			<div class="span-18">
				<div class="span-5">
					<span class="label1">综合评分:</span>
				</div>
				<div id="locPoint" class="span-13">
					<img src="{base_url()}/resource/img/loader.gif" />
				</div>
			</div>
		</div>
	</div>
	<div class="span-28">
		<div class="span-5">
			照片
		</div>
		<div class="span-23">
			<img height="240" width="320" src="{if $talentInfo['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talentInfo['photoURL']}{/if}" />
		</div>
		<div class="span-5">
			视频
		</div>
		<div class="span-23">
			<!--{if $talentInfo['videoURL'] == NULL}-->
			<img height="240" width="320" src="{base_url()}resource/img/defaultPhoto.png" />
			<!--{else}-->
			<a
			href="{$talentInfo['videoURL']}"
			style="display:block;width:320px;height:240px"
			id="locPlayer"> </a>
			<!-- this will install flowplayer inside previous A- tag. -->
			<!--{/if}-->
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				城市
			</div>
			<div class="span-16">
				{$talentInfo['cityList']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				商区
			</div>
			<div class="span-16">
				{$talentInfo['businessAreaList']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				性别
			</div>
			<div class="span-16">
				{$talentInfo['sex']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				婚否
			</div>
			<div class="span-16">
				{$talentInfo['marriage']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				身高
			</div>
			<div class="span-16">
				{$talentInfo['height']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				学历
			</div>
			<div class="span-16">
				{$talentInfo['education']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				外表相关
			</div>
			<div class="span-16">
				{$talentInfo['appearance']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				语言表达相关
			</div>
			<div class="span-16">
				{$talentInfo['expression']}
			</div>
		</div>
		<div class="span-5">
			备注
		</div>
		<div class="span-23">
			<form action="">
				<textarea id="enterpriseNote" style="width:315px; height:100px">{$enterpriseNote|default:''}</textarea>
				<input id="saveButton" type="button" value="保存" />
				<input type="reset" value="重置" />
			</form>
		</div>
		<div id="msg" class="span-5"></div>
	</div>
</div>
<div class="prepend-2 span-30">
	<div id="historySection" class="span-30"></div>
	<div id="locButtonLayout" class="span-30"></div>
</div>
<!--{/block}-->