<!--{extends file='hunterPage.tpl'}-->
<!--{block name=title}-->
<title>猎头人才库</title>
<!--{/block}-->
<!--{block name=style}-->
<style type="text/css" media="screen">
	.locHMiddle {
		text-align: center;
	}
</style>
<!--{/block}-->
<!--{block name=subBody}-->
<div class="prepend-2 span-60">
	<div class="span-60">
		<div class="span-20">
			<h3 class="locHMiddle">客户</h3>
		</div>
		<div class="span-40">
			<h3 class="locHMiddle">管理进度</h3>
		</div>
	</div>
	<div class="span-60">
		<div class="span-20">
			&nbsp;
		</div>
		<div class="span-40">
			<div class="span-5 locHMiddle">
				<span class="text1">面试人数</span>
			</div>
			<div class="span-5 locHMiddle">
				<span class="text1">offer人数</span>
			</div>
			<div class="span-5 locHMiddle">
				<span class="text1">到岗人数</span>
			</div>
			<div class="span-5 locHMiddle">
				<span class="text1">待定人数</span>
			</div>
			<div class="span-6 locHMiddle">
				<span class="text1">被动拒绝人数</span>
			</div>
			<div class="span-6 locHMiddle">
				<span class="text1">主动拒绝人数</span>
			</div>
		</div>
	</div>
	<!--{foreach $enterpriseList as $enterprise}-->
	<div class="span-60">
		<div class="span-20">
			<span class="text1">{$enterprise['name']}</span>
		</div>
		<div class="span-40">
			<div class="span-5 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}">{$enterprise['interviewNum']}</a>
			</div>
			<div class="span-5 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}">{$enterprise['offerNum']}</a>
			</div>
			<div class="span-5 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}/other">{$enterprise['onboardNum']}</a>
			</div>
			<div class="span-5 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}/other">{$enterprise['todoNum']}</a>
			</div>
			<div class="span-6 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}/other">{$enterprise['rejectedNum']}</a>
			</div>
			<div class="span-6 locHMiddle">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}/other">{$enterprise['rejectNum']}</a>
			</div>
			<div class="span-8">
				<a class="text1" href="{site_url('hunterManageList/index')}/{$enterprise['id']}">管理人才</a>
			</div>
		</div>
	</div>
	<!--{/foreach}-->
</div>
<div class="prepend-top  prepend-2 span-60">
	<div class="prepend-52 span-8">
		<a class="text1" href="{site_url('hunterSearchF_job/index')}">进入人才库</a>
	</div>
</div>
<!--{/block}-->