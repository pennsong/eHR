<!--{extends file='enterprisePage.tpl'}-->
<!--{block name=title}-->
<title>公司职位招聘进程</title>
<!--{/block}-->
<!--{block name=style}-->
<style type="text/css" media="screen">
	.locImgDiv {
		position: relative
	}
	.locNoteDiv {
		position: absolute;
		top: 50px;
		left: 50px;
		width: 200px;
		height: 100px;
		background-color: #0000FF;
		color: yellow;
		display: none;
		z-index: 3000;
		overflow: auto;
	}
	.locSelected {
		background-color: #0000FF;
		color: #FFFFFF
	}
</style>
<!--{/block}-->
<!--{block name=subScript}-->
<script>
	$(document).ready(function() {
		$("#interviewStage").click(function() {
			$("#talentList").load("{site_url('enterpriseManageList/interviewStage')}" + "/" + $("#job").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#interviewStage").attr("class", "locSelected");
					$("#offerStage").attr("class", "");
					$("#onboardStage").attr("class", "");
					$("#todoStage").attr("class", "");
					$("#rejectStage").attr("class", "");
				}
			});
		});
		$("#offerStage").click(function() {
			$("#talentList").load("{site_url('enterpriseManageList/offerStage')}" + "/" + $("#job").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#interviewStage").attr("class", "");
					$("#offerStage").attr("class", "locSelected");
					$("#onboardStage").attr("class", "");
					$("#todoStage").attr("class", "");
					$("#rejectStage").attr("class", "");
				}
			});
		});
		$("#onboardStage").click(function() {
			$("#talentList").load("{site_url('enterpriseManageList/onboardStage')}" + "/" + $("#job").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#interviewStage").attr("class", "");
					$("#offerStage").attr("class", "");
					$("#onboardStage").attr("class", "locSelected");
					$("#todoStage").attr("class", "");
					$("#rejectStage").attr("class", "");
				}
			});
		});
		$("#todoStage").click(function() {
			$("#talentList").load("{site_url('enterpriseManageList/todoStage')}" + "/" + $("#job").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#interviewStage").attr("class", "");
					$("#offerStage").attr("class", "");
					$("#onboardStage").attr("class", "");
					$("#todoStage").attr("class", "locSelected");
					$("#rejectStage").attr("class", "");
				}
			});
		});
		$("#rejectStage").click(function() {
			$("#talentList").load("{site_url('enterpriseManageList/rejectStage')}" + "/" + $("#job").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#interviewStage").attr("class", "");
					$("#offerStage").attr("class", "");
					$("#onboardStage").attr("class", "");
					$("#todoStage").attr("class", "");
					$("#rejectStage").attr("class", "locSelected");
				}
			});
		});
		/*{if $type == 'interview'}*/
		$("#interviewStage").click();
		/*{/if}*/
		/*{if $type == 'offer'}*/
		$("#offerStage").click();
		/*{/if}*/
		/*{if $type == 'onboard'}*/
		$("#onboardStage").click();
		/*{/if}*/
		/*{if $type == 'todo'}*/
		$("#todoStage").click();
		/*{/if}*/
		/*{if $type == 'reject'}*/
		$("#rejectStage").click();
		/*{/if}*/
	}); 
</script>
<!--{/block}-->
<!--{block name=subBody}-->
<div class="prepend-2 span-60">
	<div class="span-60">
		<div class="span-5">
			<a href="{site_url('enterpriseMain')}">返回首页</a>
			<input id="job" type="hidden" value="{$job}" />
		</div>
	</div>
	<div class="span-60">
		<div class="span-5">
			<a id="interviewStage" href="#">面试阶段</a>
		</div>
		<div class="prepend-1 span-5">
			<a id="offerStage" href="#">offer阶段</a>
		</div>
		<div class="prepend-1 span-5">
			<a id="onboardStage" href="#">到岗阶段</a>
		</div>
		<div class="prepend-1 span-5">
			<a id="todoStage" href="#">待定</a>
		</div>
		<div class="prepend-1 span-5">
			<a id="rejectStage" href="#">拒绝</a>
		</div>
	</div>
	<div id="talentList" class="span-60"></div>
</div>
<!--{/block}-->
