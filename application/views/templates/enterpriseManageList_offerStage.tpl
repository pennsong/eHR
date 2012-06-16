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
		接受offer
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList7 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{base_url()}upload/{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
<div class="span-60">
	<div class="prepend-1 span-5">
		拒绝offer
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList8 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{base_url()}upload/{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
<div class="span-60">
	<div class="prepend-1 span-5">
		已发送offer
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList6 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{base_url()}upload/{$talent['photoURL']}{/if}" /></a>
			<div class="locNoteDiv">
				{$talent['hunterNote']}
			</div>
		</div>
		<div class="span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}">{$talent['personName']}</a>
		</div>
	</div>
	{/foreach}
</div>
