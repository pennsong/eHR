<!--{extends file='enterprisePage.tpl'}-->
<!--{block name=title}-->
<title>猎头信息</title>
<!--{/block}-->
<!--{block name=style}-->
<!--{/block}-->
<!--{block name=subScript}-->
<script>
	$(document).ready(function() {
		//获得对应猎头成功推荐人数
		$("#successNum").load("{site_url('enterpriseSearchF_job/getHunterSuccessNum')}/{$hunterInfo['id']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//获得对应猎头积分
		$("#point").load("{site_url('enterpriseSearchF_job/getHunterPoint')}/{$hunterInfo['id']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
		//获得猎头推荐人数
		$("#recommendNum").load("{site_url('enterpriseSearchF_job/getHunterRecommendNum')}/{$hunterInfo['id']}", function(responseText, textStatus, XMLHttpRequest) {
			if(textStatus == 'success') {
			}
		});
	}); 
</script>
<!--{/block}-->
<!--{block name=subBody}-->
<div class="prepend-2 span-38">
	<div class="span-38">
		<div class="span-5">
			猎头:
		</div>
		<div class="span-5">
			{$hunterInfo['personName']}
		</div>
	</div>
	<div class="span-38">
		<div class="prepend-2 span-34 append-2">
			{foreach $hunterTalentInfo|default:array() as $talentInfo}
			<div class="prepend-1 span-5">
				<div class="span-5">
					<img height="50" width="75" src="{if $talentInfo['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}"/>
				</div>
				<div class="span-5">
					{$talentInfo['personName']}
				</div>
			</div>
			{/foreach}
		</div>
		<div class="prepend-2 span-34 append-2">
			<div class="span-34">
				<div class="span-5">
					最近评语
				</div>
			</div>
			<div class="span-34">
				<div class="span-5">
					评价人
				</div>
				<div class="span-29">
					评语
				</div>
			</div>
			{foreach $enterpriseRemarkList|default:array() as $remark}
			<div class="span-34">
				<div class="span-5">
					{$remark['name']}
				</div>
				<div class="span-29">
					{$remark['enterpriseRemark']}
				</div>
			</div>
			{/foreach}
		</div>
	</div>
</div>
<div class="prepend-2 span-20">
	<div class="span-20">
		{$hunterInfo['personName']}
	</div>
	<div class="span-20">
		<div class="span-5">
			<span class="label1">综合评分:</span>
		</div>
		<div id="point" class="span-15">
			<img src="{base_url()}/resource/img/loader.gif" />
		</div>
	</div>
	<div class="span-20">
		<div class="span-5">
			<span class="label1">推荐人数:</span>
		</div>
		<div id="recommendNum" class="span-15">
			<img src="{base_url()}/resource/img/loader.gif" />
		</div>
	</div>
	<div class="span-20">
		<div class="span-5">
			<span class="label1">录取人数:</span>
		</div>
		<div id="successNum" class="span-15">
			<img src="{base_url()}/resource/img/loader.gif" />
		</div>
	</div>
</div>
<!--{/block}-->
