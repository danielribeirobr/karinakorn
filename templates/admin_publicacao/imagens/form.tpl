{capture name="content"}

	<h2>Imagem de {$publicacao.titulo}</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="{$form.publicacao_id}"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoImagemSalvar"/>
		<input type="hidden" name="imagem_id" id="imagem_id" value="{$form.imagem_id}"/>
		<fieldset>
			<legend>Dados da imagem</legend>
			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="{$form.titulo}"/>
			{if $error.titulo}
				<div class="error">{$error.titulo}</div>
			{/if}
			<br/>

			{if !$form.imagem_id}
				<label for="imagem_tipo_id">Tipo:</label>
				<select name="imagem_tipo_id" id="imagem_tipo_id">
					<option value="">--Selecione--</option>
					{foreach from=$form.imagem_tipo item=item}
						<option value="{$item.imagem_tipo_id}" {if $item.imagem_tipo_id == $form.imagem_tipo_id} selected {/if}>{$item.tipo}</option>
					{/foreach}
				</select>
			{if $error.imagem_tipo_id}
				<div class="error">{$error.imagem_tipo_id}</div>
			{/if}
				<br/>
			{/if}

			<label for="descricao">Descri&ccedil;&atilde;o:</label>
			<textarea name="descricao" id="descricao">{$form.descricao}</textarea>
			{if $error.descricao}
				<div class="error">{$error.descricao}</div>
			{/if}
			<br/>

			{if !$form.imagem_id}
				<label for="arquivo">Arquivo:</label>
				<input type="file" name="arquivo" id="arquivo"/>
				{if $error.arquivo}
					<div class="error" style="margin-left: 60px;">{$error.arquivo}</div>
				{/if}
				<br/>
			{/if}

			<input type="submit" value="Salvar" class="submit" style="width: 120px;"/>
			<input type="button" value="Voltar" class="submit2" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoImagemListar&publicacao_id={$form.publicacao_id}';"/>

			{if $form.imagem_id}
				<br/><br/>
				<img src="{$appConfig.db_imagens}{$form.arquivo}" style="margin-left: 174px;"/>
			{/if}

		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}