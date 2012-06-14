<!--{extends file='hunterPage.tpl'}-->
<!--{block name=title}-->
<title>猎头招聘进程</title>
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
		$("#todoStage").click(function() {
			$("#talentList").load("{site_url('hunterManageList/todoStage')}" + "/" + $("#enterprise").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#todoStage").attr("class", "locSelected");
					$("#otherStage").attr("class", "");
				}
			});
		});
		$("#otherStage").click(function() {
			$("#talentList").load("{site_url('hunterManageList/otherStage')}" + "/" + $("#enterprise").val(), function(responseText, textStatus, XMLHttpRequest) {
				if(textStatus == 'success') {
					$("#todoStage").attr("class", "");
					$("#otherStage").attr("class", "locSelected");
				}
			});
		});
		/*{if $type == 'todo'}*/
		$("#todoStage").click();
		/*{/if}*/
		/*{if $type == 'other'}*/
		$("#otherStage").click();
		/*{/if}*/
	}); 
</script>
<!--{/block}-->
<!--{block name=subBody}-->
<div class="prepend-2 span-60">
	<div class="span-60">
		<div class="span-5">
			<a href="{site_url('hunterMain')}">返回首页</a>
			<input id="enterprise" type="hidden" value="{$enterprise}" />
		</div>
	</div>
	<div class="span-60">
		<div class="span-5">
			<a id="todoStage" href="#">待办</a>
		</div>
		<div class="prepend-1 span-5">
			<a id="otherStage" href="#">其他</a>
		</div>
	</div>
	<div id="talentList" class="span-60"></div>
</div>
<!--{/block}-->
