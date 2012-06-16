<!--{$jqueryHead}-->
<!--{$flowplayerHead}-->
<script>
	$(document).ready(function() {
		//设置保存按钮事件
		$("#saveButton").click(function() {
			//取得城市数组
			var cityList = [];
			$("#cityOption").find("[checked='checked']").each(function() {
				cityList.push($(this).val()+"array_");
			});
			//取得商区数组
			var businessAreaList = [];
			$("#businessAreaOption").find("[checked='checked']").each(function() {
				businessAreaList.push($(this).val()+"array_");
			});
			//取得适合行业数组
			var fitIndustryList = [];
			$("#fitIndustryOption").find("[checked='checked']").each(function() {
				fitIndustryList.push($(this).val()+"array_");
			});
			//取得不适合行业数组
			var unfitIndustryList = [];
			$("#unfitIndustryOption").find("[checked='checked']").each(function() {
				unfitIndustryList.push($(this).val()+"array_");
			});
			var dataString = 'talent=' + $("#talent").val() + '&talentPersonName=' + $("#talentPersonName").val() + '&birthYear=' + $("#birthYear").val() + '&photoURL=' + $("#photoURL").val() + '&videoURL=' + $("#videoURL").val() + '&cityList=' + cityList + '&businessAreaList=' + businessAreaList + '&sex=' + $("#sexInput").val() + '&marriage=' + $("#marriageInput").val() + '&height=' + $("#heightInput").val() + '&education=' + $("#educationInput").val() + '&appearance=' + $("#appearanceInput").val() + '&expression=' + $("#expressionInput").val() + '&fitIndustryList=' + fitIndustryList + '&unfitIndustryList=' + unfitIndustryList + '&release=' + $("#releaseInput").val() + '&hunterNote=' + $("#hunterNoteInput").val();
			$.ajax({
				type : "POST",
				url : "{site_url('hunterSearchF_job/validate')}",
				data : dataString,
				success : function(responseText, textStatus, XMLHttpRequest) {
					$(".locDraw").html(responseText);
				}
			});
			return false;
		});
		//设置人才数据编辑事件
		$(".locOption").click(function() {
			var tmpParent = $(this).parent();
			var tmpThis = $(this);
			var originalClassString = "link2 locOption";
			//判断是否是多选
			if(tmpParent.attr('multi') == 'true') {
				//多选
				//判断是否是点击了清空选项
				if(tmpThis.attr('idValue') == '') {
					//清空操作
					tmpParent.find(".locOption").attr("class", originalClassString);
					tmpParent.find("[type='checkbox']").removeAttr("checked");
				} else {
					if(tmpThis.next("[type='checkbox']").attr("checked") == 'checked') {
						tmpThis.attr("class", originalClassString);
						tmpThis.next("[type='checkbox']").removeAttr("checked");
					} else {
						tmpThis.attr("class", originalClassString + " locSelected");
						tmpThis.next("[type='checkbox']").attr("checked", 'checked');
					}
				}
			} else {
				//单选
				tmpParent.find(".locOption").attr("class", originalClassString);
				tmpThis.attr("class", originalClassString + " locSelected");
				tmpParent.find("[class*='data']").val(tmpThis.attr('idValue'));
			}
			return false;
		});
		//设置人才相关数据
		/*{foreach $smarty.post.cityList as $cityInfo}*/
		$("#cityOption").find("[idValue='{$cityInfo['id']}']").click();
		/*{/foreach}*/
		/*{foreach $smarty.post.businessAreaList as $businessAreaInfo}*/
		$("#businessAreaOption").find("[idValue='{$businessAreaInfo['id']}']").click();
		/*{/foreach}*/
		$("#sexOption").find("[idValue='{$smarty.post.sex}']").click();
		$("#marriageOption").find("[idValue='{$smarty.post.marriage}']").click();
		$("#educationOption").find("[idValue='{$smarty.post.education}']").click();
		$("#appearanceOption").find("[idValue='{$smarty.post.appearance}']").click();
		$("#expressionOption").find("[idValue='{$smarty.post.expression}']").click();
		/*{foreach $smarty.post.fitIndustryList as $fitIndustryInfo}*/
		$("#fitIndustryOption").find("[idValue='{$fitIndustryInfo['id']}']").click();
		/*{/foreach}*/
		/*{foreach $smarty.post.unfitIndustryList as $unfitIndustryInfo}*/
		$("#unfitIndustryOption").find("[idValue='{$unfitIndustryInfo['id']}']").click();
		/*{/foreach}*/
		$("#releaseOption").find("[idValue='{$smarty.post.release}']").click();
		//设置视频
		flowplayer("locPlayer", "{base_url()}resource/flowplayer/flowplayer-3.2.7.swf", {
			clip : {
				autoPlay : false,
				autoBuffering : true
			}
		});
	}); 
</script>
<div class="span-28">
	<div class="span-28">
		<div class="span-5">
			{$smarty.post.talentPersonName}
			<input type="hidden" id="talent" value="{$smarty.post.talent}" />
			<input type="hidden" id="talentPersonName" value="{$smarty.post.talentPersonName}" />
			<input type="hidden" id="birthYear" value="{$smarty.post.birthYear}" />
			<input type="hidden" id="photoURL" value="{$smarty.post.photoURL}" />
			<input type="hidden" id="videoURL" value="{$smarty.post.videoURL}" />
		</div>
	</div>
	<div class="span-28">
		<div class="span-5">
			照片
		</div>
		<div class="span-23">
			<img height="240" width="320" src="{if $smarty.post.photoURL == NULL}{base_url()}resource/img/defaultPhoto.png{else}{base_url()}upload/{$smarty.post.photoURL}{/if}" />
		</div>
		<div class="span-5">
			视频
		</div>
		<div class="span-23">
			<!--{if $smarty.post.videoURL == NULL}-->
			<img height="240" width="320" src="{base_url()}resource/img/defaultPhoto.png" />
			<!--{else}-->
			<a
			href="{base_url()}upload/{$smarty.post.videoURL}"
			style="display:block;width:320px;height:240px"
			id="locPlayer"> </a>
			<!-- this will install flowplayer inside previous A- tag. -->
			<!--{/if}-->
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				城市
			</div>
			<div id="cityOption" class="span-16" multi="true">
				<a href="#" class="link2 locOption" idValue="">无</a>
				<!--{foreach $cityList as $city}-->
				<a href="#" class="link2 locOption" idValue="{$city['id']}">{$city['name']}</a>
				<input class="hiddenInput data" type="checkbox" name="cityList[]" value="{$city['id']}" id="cityList[]">
				<!--{/foreach}-->
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				商区
			</div>
			<div id="businessAreaOption" class="span-16" multi="true">
				<a href="#" class="link2 locOption" idValue="">无</a>
				<!--{foreach $businessAreaList as $businessArea}-->
				<a href="#" class="link2 locOption" idValue="{$businessArea['id']}">{$businessArea['name']}</a>
				<input class="hiddenInput data" type="checkbox" name="businessAreaList[]" value="{$businessArea['id']}" id="businessAreaList[]">
				<!--{/foreach}-->
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				性别
			</div>
			<div id="sexOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="">未知</a>
				<!--{foreach $sexList as $sex}-->
				<a href="#" class="link2 locOption" idValue="{$sex['id']}">{$sex['name']}</a>
				<!--{/foreach}-->
				<input class="hiddenInput data" type="hidden" name="sex" value="" id="sexInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				婚否
			</div>
			<div id="marriageOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="">未知</a>
				<a href="#" class="link2 locOption" idValue="0">未婚</a>
				<a href="#" class="link2 locOption" idValue="1">已婚</a>
				<input class="hiddenInput data" type="hidden" name="marriage" value="" id="marriageInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				身高
			</div>
			<div class="span-16">
				<input class="data" type="text" name="height" value="{$smarty.post.height}" id="heightInput">
				CM
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				学历
			</div>
			<div id="educationOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="">未知</a>
				<!--{foreach $educationList as $education}-->
				<a href="#" class="link2 locOption" idValue="{$education['id']}">{$education['name']}</a>
				<!--{/foreach}-->
				<input class="data" type="hidden" name="education" value="" id="educationInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				外表相关
			</div>
			<div id="appearanceOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="">未知</a>
				<!--{foreach $appearanceList as $appearance}-->
				<a href="#" class="link2 locOption" idValue="{$appearance['id']}">{$appearance['name']}</a>
				<!--{/foreach}-->
				<input class="data" type="hidden" name="appearance" value="" id="appearanceInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				语言表达相关
			</div>
			<div id="expressionOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="">未知</a>
				<!--{foreach $expressionList as $expression}-->
				<a href="#" class="link2 locOption" idValue="{$expression['id']}">{$expression['name']}</a>
				<!--{/foreach}-->
				<input class="data" type="hidden" name="expression" value="" id="expressionInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				适合行业
			</div>
			<div id="fitIndustryOption" class="span-16" multi="true">
				<a href="#" class="link2 locOption" idValue="">无</a>
				<!--{foreach $fitIndustryList as $fitIndustry}-->
				<a href="#" class="link2 locOption" idValue="{$fitIndustry['id']}">{$fitIndustry['name']}</a>
				<input class="hiddenInput data" type="checkbox" name="fitIndustryList[]" value="{$fitIndustry['id']}" id="fitIndustryList[]">
				<!--{/foreach}-->
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				不适合行业
			</div>
			<div id="unfitIndustryOption" class="span-16" multi="true">
				<a href="#" class="link2 locOption" idValue="">无</a>
				<!--{foreach $unfitIndustryList as $unfitIndustry}-->
				<a href="#" class="link2 locOption" idValue="{$unfitIndustry['id']}">{$unfitIndustry['name']}</a>
				<input class="hiddenInput data" type="checkbox" name="unfitIndustryList[]" value="{$unfitIndustry['id']}" id="unfitIndustryList[]">
				<!--{/foreach}-->
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-7 label1">
				是否发布
			</div>
			<div id="releaseOption" class="span-16">
				<a href="#" class="link2 locOption" idValue="0">否</a>
				<a href="#" class="link2 locOption" idValue="1">是</a>
				<input class="hiddenInput data" type="hidden" name="release" value="{$smarty.post.release}" id="releaseInput">
			</div>
		</div>
		<div class="prepend-5 span-23">
			<div class="span-4 label1">
				备注
			</div>
			<div class="span-19">
				<textarea class="data" id="hunterNoteInput" style="width:250px; height:100px">{$smarty.post.hunterNote}</textarea>
			</div>
		</div>
		<div id="test" class="prepend-5 span-23">
			<!--{if isset($errorMsg)}-->
			<!--{$errorMsg}-->
			<!--{elseif isset($okMsg)}-->
			<span class="ok1">{$okMsg}</span>
			<!--{/if}-->
			<input id="saveButton" type="button" value="保存" />
		</div>
	</div>
</div>