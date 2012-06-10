<div class="span-5 label1">
	招聘城市
</div>
<div class="span-9">
	
	{html_options id=city name=city options=$cityList selected=($city|default:'')}
</div>
<div class="span-5 label1">
	招聘商圈
</div>
<div class="span-9">
	{html_options id=businessArea name=businessArea options=$businessAreaList selected=($businessArea|default:'')}
</div>