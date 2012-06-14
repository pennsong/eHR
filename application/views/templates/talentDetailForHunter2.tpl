<!--{extends file='hunterPage.tpl'}-->
<!--{block name=title}-->
<title>人才详细信息</title>
<!--{/block}-->
<!--{block name=style}-->
<style>
	.locSelected {
		background-color: #0000FF;
		color: #FFFFFF
	}
</style>
<!--{/block}-->
<!--{block name=subScript}-->
<!--{$flowplayerHead}-->
<script>
	$(document).ready(function() {
		$("#todoList").click(function() {
			//获得待办事项
			$("#todoOrHistorySection").load("{site_url('hunterSearchF_job/getDealTodo')}/{$talentInfo['id']}/{$enterprise}", function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#todoList").attr("class", "locSelected");
					$("#historyList").attr("class", "");
				}
			});
		});
		$("#historyList").click(function() {
			//获得交易历史
			$("#todoOrHistorySection").load("{site_url('hunterSearchF_job/getDealHistory')}/{$talentInfo['id']}/{$CI->session->userdata('userId')}/{$enterprise}", function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#todoList").attr("class", "");
					$("#historyList").attr("class", "locSelected");
				}
			});
		});
		//默认打开待办事项
		$("#todoList").click();
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
		<a href="{site_url('hunterManageList/index/')}/{$enterprise}">返回上一级</a>
	</div>
</div>
<div class="span-28">
	<div class="span-28">
		<input id="enterprise" type="hidden" value="{$enterprise}" />
		<div class="span-5">
			{$talentInfo['talentPersonName']}
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
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				猎头备注
			</div>
			<div class="span-16">
				{$talentInfo['hunterNote']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				适合行业
			</div>
			<div class="span-16">
				{$talentInfo['fitIndustryList']}
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				不适合行业
			</div>
			<div class="span-16">
				{$talentInfo['unfitIndustryList']}
			</div>
		</div>
	</div>
</div>
<div class="prepend-2 span-30">
	<div class="span-5">
		<a id="todoList" href="#">待办事项</a>
	</div>
	<div class="span-5">
		<a id="historyList" href="#">历史记录</a>
	</div>
	<div id="todoOrHistorySection" class="span-30"></div>
</div>
<!--{/block}-->