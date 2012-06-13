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
		录用通知
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList6 as $talent}
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
		面试通知
	</div>
</div>
<div class="span-60">
	{foreach $talentInfoList2 as $talent}
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
