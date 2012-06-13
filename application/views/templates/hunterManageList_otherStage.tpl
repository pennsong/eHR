<script>
	$(document).ready(function() {
		$(".locImgDiv").hover(function() {
			$(".locNoteDiv", this).show();
		}, function() {
			$(".locNoteDiv", this).hide();
		});
	}); 
</script>
<div class="span-60">
	<div class="prepend-1 span-5">
		被企业拒绝
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList5 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
<div class="span-60">
	<div class="prepend-1 span-5">
		拒绝面试或offer
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList4_5 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
<div class="span-60">
	<div class="prepend-1 span-5">
		已录用
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList7 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
<div class="span-60">
	<div class="prepend-1 span-5">
		待定
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList1 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('hunterManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$enterprise}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
