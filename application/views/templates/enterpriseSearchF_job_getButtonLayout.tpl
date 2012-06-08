<script>
	$(document).ready(function() {
		$("#locInterview").click(function() {
			var url;
			if($("#locDeal").val() == '') {
				ajaxURL = "{cw_ci_site_url param1='enterpriseSearchF_job/createDeal'}/" + $("#talent").val() + '/' + $("#jobId").val() + '/' + '2'/*interviewStatus:2*/;
			} else {
				ajaxURL = "{cw_ci_site_url param1='enterpriseSearchF_job/createStatusF_deal'}/" + $("#locDeal").val() + '/' + '2'/*interviewStatus:2*/ + '/notemsg';
			}
			$.ajax({
				url : ajaxURL,
				success : function(data, textStatus, jqXHR) {
					if(data == "ok") {
						setButtonLayout(2);
					} else {
						alert('状态设置失败请重试!');
					}
				}
			});
		});
		$("#locTodo").click(function() {
			alert("d");
		});
		$("#locReject").click(function() {
			alert("d");
		});
	});
	function setButtonLayout(status) {
		//设置面试键
		if($.inArray(status, [0, 1, 3]) > -1) {
			$("#locInterview").attr('disabled', '');
		} else {
			$("#locInterview").attr('disabled', 'disabled');
		}
		//设置待定键
		if($.inArray(status, [0]) > -1) {
			$("#locTodo").attr('disabled', '');
		} else {
			$("#locTodo").attr('disabled', 'disabled');
		}
		//设置拒绝键
		if($.inArray(status, [3]) > -1) {
			$("#locReject").attr('disabled', '');
		} else {
			$("#locReject").attr('disabled', 'disabled');
		}
	}
</script>
<input id="locDeal" type="hidden" value="{$deal|default:''}"/>
<div class="prepend-6 span-4">
	<div style="position:relative">
		<button id="locInterview" {if $interviewDisabled}disabled{/if}>
			面试
		</button>
		<div class="span-20" style="position:absolute; top:25px; left:2px; background:red">
			<form action="#" method="post">
				<div span="span-20">
					<div class="span-4">
						时间1
					</div>
					<div class="span-5">
						<input id="time1" type="text" />
					</div>
				</div>
				<div class="span-20">
					<div class="span-4">
						时间2
					</div>
					<div class="span-5">
						<input id="time2" type="text" />
					</div>
				</div>
				<div class="span-20">
					<div class="span-4">
						时间3
					</div>
					<div class="span-5">
						<input id="time3" type="text" />
					</div>
				</div>
				<div class="span-20">
					<div class="span-4">
						地址
					</div>
					<div class="span-16">
						<input id="address" type="text" />
					</div>
				</div>
				<div class="span-20">
					<div class="span-4">
						<input type="submit" value="保存"/>
					</div>
					<div class="span-4">
						<input type="button" value="取消" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="prepend-2 span-4">
	<button id="locTodo" {if $todoDisabled}disabled{/if}>
		待定
	</button>
</div>
<div class="prepend-2 span-4">
	<button id="locReject" {if $rejectDisabled}disabled{/if}>
		拒绝
	</button>
</div>