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
	<div class="span-10">
		操作明细
	</div>
	<div class="span-5">
		时间
	</div>
</div>
<!--{if isset($dealHistory)}-->
<!--{foreach $dealHistory as $history}-->
<div class="span-30">
	<div class="span-5">
		<!--{if $history['role']=='enterpriseUser'}-->
		<span>公司用户:</span>
		<!--{elseif $history['role']=='hunter'}-->
		<span>猎头:</span>
		<!--{/if}-->
		{$history['name']}
	</div>
	<div class="span-5">
		{$history['title']}
	</div>
	<div class="span-5">
		{$history['statusName']}
	</div>
	<div class="span-10">
		{$history['note']}
	</div>
	<div class="span-5">
		{$history['created']}
	</div>
</div>
<!--{/foreach}-->
<!--{/if}-->
