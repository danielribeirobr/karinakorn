{capture name="content"}

	<h2>Detalhamento de {$publicacao.titulo}</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="{$publicacao.publicacao_id}"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoDetalhesSalvar"/>
		<fieldset>
			<legend>Dados detalhados da publicação</legend>
			{foreach from=$campos item=campo}
				<label for="titulo">{$campo.campo}:</label>
				{assign var='campo_id' value=$campo.campo_id}
				{assign var='var_name' value=campo_$campo_id}
				{assign var='value' value=$form.$var_name}
				{if $campo.campo_tipo == 'text'}
					<input type="text" name="campo_{$campo.campo_id}" id="campo_{$campo.campo_id}" value="{$value}"/>
				{/if}
				{if $campo.campo_tipo == 'combo'}
					<select name="campo_{$campo.campo_id}" id="campo_{$campo.campo_id}">
						<option value="">-- selecione --</option>
						{foreach from=$campo.values item=v}
							<option value="{$v}" {if $value == $v} selected {/if}>{$v}</option>
						{/foreach}
					</select>
				{/if}
				{if $campo.campo_tipo == 'textarea'}
					<textarea name="campo_{$campo.campo_id}" id="campo_{$campo.campo_id}">{$value}</textarea>
				{/if}
				<br/>
			{/foreach}
			<input type="submit" class="submit" value="Salvar"/>
			<input type="button" class="submit2" value="Voltar" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id={$publicacao.publicacao_id}';"/>
		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}