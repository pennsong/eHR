<script>
	$(document).ready(function() {
		$("#locInterview").click(function() {
			$("#interviewNote").show();
		});
		$("#cancelInterviewNote").click(function() {
			$("#interviewNote").hide();
		});
		$("#saveInterviewNote").click(function() {
			submitInterview(2);
		});
		$("#locTodo").click(function() {
			submitInterview(1);
		});
		$("#locReject").click(function() {
			submitInterview(5);
		});
		$("#locOnboard").click(function() {
			submitInterview(9);
		});
		$("#locOffer").click(function() {
			submitInterview(6);
		});
		$("#saveDealEnterpriseRemark").click(function() {
			submitEnterpriseRemark();
		});
	});
	function setButtonLayout(status) {
		//设置面试键
		$("button:disabled").removeAttr('disabled');
		if($.inArray(status, [0, 1, 3]) > -1) {
		} else {
			$("#locInterview").attr('disabled', 'disabled');
		}
		//设置待定键
		if($.inArray(status, [0]) > -1) {
		} else {
			$("#locTodo").attr('disabled', 'disabled');
		}
		//设置拒绝键
		if($.inArray(status, [2, 3]) > -1) {
		} else {
			$("#locReject").attr('disabled', 'disabled');
		}
		//设置到岗键
		if($.inArray(status, [7]) > -1) {
		} else {
			$("#locOnboard").attr('disabled', 'disabled');
		}
		//设置offer键
		if($.inArray(status, [1, 3]) > -1) {
		} else {
			$("#locOffer").attr('disabled', 'disabled');
		}
	}

	function submitInterview(status) {
		var url;
		ajaxURL = "{site_url('enterpriseSearchF_job/createStatusF_deal')}/" + $("#talent").val() + '/' + $("#jobId").val() + "/" + status + "/" + encodeURIComponent(noteMsg(status));
		$.ajax({
			url : ajaxURL,
			success : function(data, textStatus, jqXHR) {
				if(data == "ok") {
					setButtonLayout(status);
					if(status == 2) {
						/*2是邀请面试状态*/
						$("#interviewNote").hide();
					}
					if(status == 9) {
						/*2是到岗状态*/
						$("#dealEnterpriseRemark").show();
					}
				} else {
					alert('状态设置失败请重试!');
				}
			}
		});
	}

	function submitEnterpriseRemark() {
		var url;
		ajaxURL = "{site_url('enterpriseSearchF_job/saveEnterpriseRemark')}/" + $("#talent").val() + '/' + $("#jobId").val() + "/" + $("#accurateInput").val() + '/' + $("#communicationInput").val() + "/" + $("#qualityInput").val() + "/" + encodeURIComponent($("#enterpriseRemarkInput").val());
		$.ajax({
			url : ajaxURL,
			success : function(data, textStatus, jqXHR) {
				if(data == "ok") {
					$("#dealEnterpriseRemark").hide();
				} else {
					alert('状态设置失败请重试!');
				}
			}
		});
	}

	function noteMsg(status) {
		/*2是邀请面试状态*/
		if(status == 2) {
			return $("#time1").val() + "," + $("#time2").val() + "," + $("#time3").val() + "," + $("#address").val();
		} else {
			return '';
		}
	}
</script>
<div class="prepend-6 span-4">
	<div style="position:relative">
		<button id="locInterview" {if $interviewDisabled}disabled{/if}>
			面试
		</button>
		<div id="interviewNote" class="span-20" style="position:absolute; top:25px; left:2px; border:1px solid; padding:5px; border-color:gray; display:none">
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
					<input id="saveInterviewNote" type="button" value="保存"/>
				</div>
				<div class="span-4">
					<input id="cancelInterviewNote" type="button" value="取消" />
				</div>
			</div>
		</div>
	</div>
</div>
<div class="span-6">
	<button id="locOffer" {if $offerDisabled}disabled{/if}>
		发送offer
	</button>
</div>
<div class="span-4">
	<button id="locTodo" {if $todoDisabled}disabled{/if}>
		待定
	</button>
</div>
<div class="span-4">
	<button id="locReject" {if $rejectDisabled}disabled{/if}>
		拒绝
	</button>
</div>
<div class="span-4">
	<div style="position:relative">
		<button id="locOnboard" {if $onboardDisabled}disabled{/if}>
			到岗
		</button>
		<div id="dealEnterpriseRemark" class="span-20" style="position:absolute; top:25px; left:-320px; border:1px solid; padding:5px; border-color:gray; display:none">
			<div span="span-20">
				<div class="span-4">
					描述准确率:
				</div>
				<div class="span-5">
					<input id="accurateInput" type="text" />
				</div>
			</div>
			<div class="span-20">
				<div class="span-4">
					沟通顺畅度:
				</div>
				<div class="span-5">
					<input id="communicationInput" type="text" />
				</div>
			</div>
			<div class="span-20">
				<div class="span-4">
					应聘者优劣:
				</div>
				<div class="span-5">
					<input id="qualityInput" type="text" />
				</div>
			</div>
			<div class="span-20">
				<div class="span-4">
					评语
				</div>
				<div class="span-16">
					<input id="enterpriseRemarkInput" type="text" />
				</div>
			</div>
			<div class="span-20">
				<div class="span-4">
					<input id="saveDealEnterpriseRemark" type="button" value="保存"/>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clear prepend-6 span-10">
	目前状态:{$dealStatusName}
</div>