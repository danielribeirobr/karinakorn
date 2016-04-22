{capture name="content"}
	<h2>Anexo de {$publicacao.titulo}</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="{$form.publicacao_id}"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoAnexoSalvar"/>
		<input type="hidden" name="anexo_id" id="anexo_id" value="{$form.anexo_id}"/>
		<fieldset>
			<legend>Dados do anexo</legend>
			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="{$form.titulo}"/>
			{if $error.titulo}
				<div class="error">{$error.titulo}</div>
			{/if}
			<br/>

			{if $error.anexo_categoria_id}
				<div class="error">{$error.anexo_categoria_id}</div>
			{/if}
			<br/>

			<label for="arquivo">Arquivo:</label>
			{if !$form.anexo_id}
				<input type="file" name="arquivo" id="arquivo"/>
				{if $error.arquivo}
					<div class="error" style="margin-left: 60px;">{$error.arquivo}</div>
				{/if}
			{else}
				<a href="?module=admin_publicacao&action=downloadAnexo&anexo_id={$form.anexo_id}">Download</a>
			{/if}
			<br/><br/>

			<input type="submit" value="Salvar" class="submit" style="width: 120px;"/>
			<input type="button" value="Voltar" class="submit2" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoAnexoListar&publicacao_id={$form.publicacao_id}';"/>
		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}