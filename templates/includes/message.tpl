{capture name="content"}
	<div style="text-align: center; margin-top: 100px;">
		<p>{$message}</p>
		<input type="button" value="voltar" onclick="document.location.href='{$link}';"/>
	</div>
{/capture}
{include file="includes/template.tpl"}