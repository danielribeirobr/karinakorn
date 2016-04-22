{capture name="content"}
	<h2>Imagens de {$publicacao.titulo}</h2>

	<input type="button" value="voltar" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id={$parameters.publicacao_id}'"/>
	<input type="button" value="adicionar imagem" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoImagemNovo&publicacao_id={$parameters.publicacao_id}'"/>
	<table class="listing">
			<thead>
				<tr>
					<th>Tipo</th>
					<th>T&iacute;tulo</th>
					<th colspan="2">Ordem</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$imagens item=item}
					<tr class="{cycle values="line1,line2"}">
						<td>{$item.imagem_tipo}</td>
						<td>{$item.titulo}</td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemSetOrder&imagem_id={$item.imagem_id}&publicacao_id={$parameters.publicacao_id}&direction=up">Subir</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemSetOrder&imagem_id={$item.imagem_id}&publicacao_id={$parameters.publicacao_id}&direction=down">Descer</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemAbrir&imagem_id={$item.imagem_id}&publicacao_id={$parameters.publicacao_id}">editar</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemExcluir&imagem_id={$item.imagem_id}&publicacao_id={$parameters.publicacao_id}">excluir</a></td>
					</tr>
				{foreachelse}
					<tr class="not_found">
						<td colspan="10">Nenhuma imagem cadastrada nesta publicação</td>
					</tr>
				{/foreach}
			</tbody>
	</table>
{/capture}
{include file="includes/template.tpl"}