<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<title>公司用户首页</title>
		<style type="text/css" media="screen">
			.locHMiddle {
				text-align: center;
			}
		</style>
		<script>
			function openWindow() {
				var browser = navigator.appName;
				if(browser == "Microsoft Internet Explorer") {
					window.opener = self;
				}
				{}
				window.open("{site_url('enterpriseInfo/index')}", 'null', 'width=550,height=480,toolbar=no,scrollbars=no,location=no,resizable=no');
			}
		</script>
	</head>
	<body>
		<div class="container ">
			<div class="span-64 last">
				<div class="span-49">
					<img class="" src="{base_url()}resource/img/logo.png"/>
				</div>
				<div class="span-12">
					<a href="#" onclick="openWindow()">欢迎您,公司用户:{$CI->session->userdata('enterpriseName')}</a>
				</div>
				<div class="span-3">
					<a href="{site_url('login/logout')}">退出</a>
				</div>
			</div>
			<div class="prepend-top span-64 last">
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
								<a class="text1" href="{site_url('jobInfo/index')}/{$job['id']}">{$job['requireNumber']}</a>
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
						<a class="link1" href="#">查看现有职位</a>
					</div>
					<div class="span-8">
						<a class="link1" href="#">创建新职位</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
