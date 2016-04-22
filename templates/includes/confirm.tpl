{capture name="content"}
	<div style="text-align:center; margin-top: 100px;">
		<p>{$message}</p>
		<input type="button" value="sim" onclick="document.location.href='{$link}'"/>
		<input type="button" value="n&atilde;o" onclick="history.back();"/>
	</div>
{/capture}
{include file="includes/template.tpl"}