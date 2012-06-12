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
		已到岗
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList9 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
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
		未到岗
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList10 as $talent}
	<div class="prepend-1 span-5">
		<div class="locImgDiv span-5">
			<a href="{site_url('enterpriseManageListDetail/getTalentDetailContent')}/{$talent['id']}/{$job}"><img height="50" width="75" src="{if $talent['photoURL'] == NULL}{base_url()}resource/img/defaultPhoto.png{else}{$talent['photoURL']}{/if}" /></a>
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
