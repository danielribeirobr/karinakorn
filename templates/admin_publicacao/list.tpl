{capture name="content"}

	<h1>Listagem de publicações do tipo: {$publicacao_tipo.tipo}</h1>

	<a href="?module=admin_publicacao&action=admin_publicacaoAdd&publicacao_tipo_id={$publicacao_tipo.publicacao_tipo_id}">Adicionar nova publicação</a>
  
  <!--
	<form class="form" method="post">
		<fieldset>
			<legend>Buscar obras</legend>
			<label for="identificacao">Identifica&ccedil;&atilde;o:</label>
			<input type="text" id="identificacao" name="identificacao" value="{$form.identificacao}"/>
			<input type="submit" value="listar" class="button"/>
			[<a href="?module=admin_publicacao&todos=1">listar todos</a>]
		</fieldset>
	</form>
  -->

	{if $publicacoes }
		<table class="listing">
			<thead>
				<tr>
					<th>Identifica&ccedil;&atilde;o</th>
					<th>T&iacute;tulo</th>
					<th colspan="2">Ordem</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$publicacoes item=item}
					<tr class="{cycle values="line1,line2"}">
						<td>{$item.identificacao}</td>
						<td>{$item.titulo}</td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoSetOrder&publicacao_id={$item.publicacao_id}&direction=down">Subir</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoSetOrder&publicacao_id={$item.publicacao_id}&direction=up">Descer</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id={$item.publicacao_id}">editar</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoDelete&publicacao_id={$item.publicacao_id}">excluir</a></td>
					</tr>
				{foreachelse}
					<tr class="not_found">
						<td colspan="10">Nenhuma publicação encontrada</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}

{/capture}
{include file="includes/template.tpl"}