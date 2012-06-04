<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--{$commonHead}-->
		<title>猎头首页</title>
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
				window.open("{cw_ci_site_url param1='hunterInfo/updateInfo'}", 'null', 'width=550,height=480,toolbar=no,scrollbars=no,location=no,resizable=no');
			}
		</script>
	</head>
	<body>
		<div class="container ">
			<div class="span-64 last">
				<div class="span-49">
					<img class="" src="{cw_ci_base_url}resource/img/logo.png"/>
				</div>
				<div class="span-12">
					<a href="#" onclick="openWindow()">欢迎您,猎头:{$userName}</a>
					<br />
					<a href="#">下载视频录制软件</a>
				</div>
				<div class="span-3">
					<a href="{cw_ci_site_url param1='login/logout'}">退出</a>
				</div>
			</div>
			<div class="prepend-top span-64 last">
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
								<a class="text1" href="#">{$enterprise['interviewNum']}</a>
							</div>
							<div class="span-5 locHMiddle">
								<a class="text1" href="#">{$enterprise['offerNum']}</a>
							</div>
							<div class="span-5 locHMiddle">
								<a class="text1" href="#">{$enterprise['onboardNum']}</a>
							</div>
							<div class="span-5 locHMiddle">
								<a class="text1" href="#">{$enterprise['todoNum']}</a>
							</div>
							<div class="span-6 locHMiddle">
								<a class="text1" href="#">{$enterprise['rejectedNum']}</a>
							</div>
							<div class="span-6 locHMiddle">
								<a class="text1" href="#">{$enterprise['rejectNum']}</a>
							</div>
							<div class="span-8">
								<a class="link1" href="#">管理人才</a>
							</div>
						</div>
					</div>
					<!--{/foreach}-->
				</div>
				<div class="prepend-top  prepend-2 span-60">
					<div class="prepend-52 span-8">
						<a class="link1" href="#">进入人才库</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
