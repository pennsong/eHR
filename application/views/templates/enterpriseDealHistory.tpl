<div class="span-30">
	<div class="span-7">
		用户
	</div>
	<div class="span-7">
		操作内容
	</div>
	<div class="span-9">
		操作明细
	</div>
	<div class="span-7">
		时间
	</div>
</div>
<!--{if isset($dealHistory)}-->
<!--{foreach $dealHistory as $history}-->
<div class="span-30">
	<div class="span-7">
		<!--{if $history['role']=='enterpriseUser'}-->
		<span>公司用户:</span>
		<!--{elseif $history['role']=='hunter'}-->
		<span>猎头:</span>
		<!--{/if}-->
		{$history['name']}
	</div>
	<div class="span-7">
		{$history['statusName']}
	</div>
	<div class="span-9">
		{$history['note']}
	</div>
	<div class="span-7">
		{$history['created']}
	</div>
</div>
<!--{/foreach}-->
<!--{/if}-->
