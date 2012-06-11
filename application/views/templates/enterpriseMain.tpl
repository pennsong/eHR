<!--{extends file='enterprisePage.tpl'}-->
<!--{block name=title}-->
<title>公司用户首页</title>
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
			<h3 class="locHMiddle">招聘职位</h3>
		</div>
		<div class="span-40">
			<h3 class="locHMiddle">状态</h3>
		</div>
	</div>
	<div class="span-60">
		<div class="span-20">
			&nbsp;
		</div>
		<div class="span-40">
			<div class="span-8 locHMiddle">
				<span class="text1">推荐人数</span>
			</div>
			<div class="span-8 locHMiddle">
				<span class="text1">需求人数</span>
			</div>
			<div class="span-8 locHMiddle">
				<span class="text1">选中人数</span>
			</div>
		</div>
	</div>
	<!--{foreach $jobList as $job}-->
	<div class="span-60">
		<div class="span-20">
			<span class="text1">{$job['title']}</span>
		</div>
		<div class="span-40">
			<div class="span-8 locHMiddle">
				<a class="text1" href="{site_url('enterpriseSearchF_job/index')}/{$job['id']}">{$job['fitNum']}</a>
			</div>
			<div class="span-8 locHMiddle">
				<a class="text1" href="{site_url('jobInfo/index')}/{$job['id']}">{$job['requireNumber']|default:'无限制'}</a>
			</div>
			<div class="span-8 locHMiddle">
				<a class="text1" href="#{$job['id']}">{$job['choseNum']}</a>
			</div>
			<div class="span-8">
				<a class="link1" href="#{$job['id']}">挑选人才</a>
			</div>
			<div class="span-8">
				<a class="text1" href="#{$job['id']}">管理人才</a>
			</div>
		</div>
	</div>
	<!--{/foreach}-->
</div>
<div class="prepend-top  prepend-2 span-60">
	<div class="prepend-44 span-8">
		<a class="link1" href="{site_url('enterpriseJobList')}">查看现有职位</a>
	</div>
	<div class="span-8">
		<a class="link1" href="{site_url('jobInfo/createJob')}">创建新职位</a>
	</div>
</div>
<!--{/block}-->
