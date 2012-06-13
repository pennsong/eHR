<!--{extends file='defaultPage.tpl'}-->
<!--{block name=script}-->
<script>
	function openWindow() {
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer") {
			window.opener = self;
		}
		window.open("{site_url('hunterInfo/index')}/{$CI->session->userdata('userId')}", 'null', 'width=550,height=480,toolbar=no,scrollbars=no,location=no,resizable=no');
	}
</script>
<!--{block name=subScript}-->
<!--{/block}-->
<!--{/block}-->
<!--{block name=body}-->
<div class="span-64 last">
	<div class="span-49">
		<img class="" src="{base_url()}resource/img/logo.png"/>
	</div>
	<div class="span-12">
		<a href="#" onclick="openWindow()">欢迎您,猎头:{$CI->session->userdata('userName')}</a>
		<br />
		<a href="#">下载视频录制软件</a>
	</div>
	<div class="span-3">
		<a href="{site_url('login/logout')}">退出</a>
	</div>
</div>
<div class="prepend-top span-64 last">
	<!--{block name=subBody}-->
	<!--{/block}-->
</div>
<!--{/block}-->