<script>
	$(document).ready(function() {
		$(".agree").click(function() {
			var currentStatus = $(this).parent().parent().find(".status").val();
			if(currentStatus == 2/*邀请面试*/) {
				var newStatus = 3/*接受面试*/;
			} else if(currentStatus == 6/*发送offer*/) {
				var newStatus = 7/*接受offer*/;
			}
			var ajaxURL = "{site_url('hunterSearchF_job/createStatusF_deal2')}/" + $(this).parent().parent().find(".deal").val() + "/" + newStatus;
			var objectThis = $(this);
			$.ajax({
				url : ajaxURL,
				success : function(data, textStatus, jqXHR) {
					if(data == 'ok') {
						objectThis.parent().parent().html('已经接受');
					} else {
						alert(data);
					}
				}
			});
		});
		$(".reject").click(function() {
			var currentStatus = $(this).parent().parent().find(".status").val();
			if(currentStatus == 2/*邀请面试*/) {
				var newStatus = 4/*拒绝面试*/;
			} else if(currentStatus == 6/*发送offer*/) {
				var newStatus = 8/*拒绝offer*/;
			}
			var ajaxURL = "{site_url('hunterSearchF_job/createStatusF_deal2')}/" + $(this).parent().parent().find(".deal").val() + "/" + newStatus;
			var objectThis = $(this);
			$.ajax({
				url : ajaxURL,
				success : function(data, textStatus, jqXHR) {
					if(data == 'ok') {
						objectThis.parent().parent().html('已经拒绝');
					} else {
						alert(data);
					}
				}
			});
		});
	}); 
</script>
<div class="span-30">
	<div class="span-5">
		用户
	</div>
	<div class="span-5">
		职位
	</div>
	<div class="span-5">
		操作内容
	</div>
	<div class="span-6">
		公司操作
	</div>
	<div class="span-5">
		操作时间
	</div>
	<div class="span-4">
		猎头反馈
	</div>
</div>
<!--{if isset($dealTodo)}-->
<!--{foreach $dealTodo as $todo}-->
<div class="span-30">
	<div class="span-5">
		<span>公司用户:</span>
		{$todo['enterpriseUserName']}
	</div>
	<div class="span-5">
		{$todo['title']}
	</div>
	<div class="span-5">
		{$todo['statusName']}
	</div>
	<div class="span-6">
		{$todo['note']|default:'无'}
	</div>
	<div class="span-5">
		{$todo['created']}
	</div>
	<div class="operate span-4">
		<input class="deal" type="hidden" value="{$todo['deal']}" />
		<input class="status" type="hidden" value="{$todo['status']}" />
		<div class="span-4">
			<a class="agree" href="#">同意</a>
		</div>
		<div class="span-4">
			<a class="reject" href="#">拒绝</a>
		</div>
	</div>
</div>
<!--{/foreach}-->
<!--{/if}-->
