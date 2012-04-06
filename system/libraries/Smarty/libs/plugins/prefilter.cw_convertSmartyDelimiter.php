<?php
function smarty_prefilter_convertSmartyDelimiter($tpl_source, Smarty_Internal_Template $template)
{
	return preg_replace("/(<!--)(\{.*\})(-->)/U",'${2}',$tpl_source);
}

?>