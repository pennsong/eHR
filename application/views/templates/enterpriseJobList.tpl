<!--{extends file='enterprisePage.tpl'}-->
<!--{block name=title}-->
<title>公司用户职位列表</title>
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
		<div class="locHMiddle span-10 head3">
			招聘职位
		</div>
		<div class="locHMiddle span-40 head3">
			要求
		</div>
		<div class="locHMiddle span-5 head3">
			薪资
		</div>
		<div class="locHMiddle span－5 head3">
			招聘人数
		</div>
	</div>
	<!--{foreach $jobList as $job}-->
	<div class="span-60">
		<div class="locHMiddle span-10 text1">
			<a href="{site_url('jobInfo/index/')}/{$job['id']}">{$job['title']}</a>
		</div>
		<div class="span-40 text1">
			{$job['detail']}
		</div>
		<div class="locHMiddle span-5 text1">
			{$job['salaryFrom']}
		</div>
		<div class="locHMiddle span-5 text1">
			{$job['requireNumber']}
		</div>
	</div>
	<!--{/foreach}-->
	<div class="prepend-top span-60">
		<div class="span-8">
			<a href="{site_url('jobInfo/createJob')}">添加新职位</a>
		</div>
		<div class="prepend-2 span-3">
			<a href="{site_url('enterpriseMain')}">返回</a>
		</div>
	</div>
</div>
<!--{/block}-->
