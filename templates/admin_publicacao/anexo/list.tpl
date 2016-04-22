{capture name="content"}
	<h2>Anexos de {$publicacao.titulo}</h2>

	<input type="button" value="voltar" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id={$parameters.publicacao_id}'"/>
	<input type="button" value="adicionar anexo" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoAnexoNovo&publicacao_id={$parameters.publicacao_id}'"/>
	<table class="listing">
			<thead>
				<tr>
					<th>T&iacute;tulo</th>
					<!--<th>Data</th>-->
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$anexos item=item}
					<tr class="{cycle values="line1,line2"}">
						<td>{$item.titulo}</td>
						<!--<td>{$item.data|date_format:"%d/%m/%Y"}</td>-->
						<td><a href="?module=admin_publicacao&action=admin_publicacaoAnexoAbrir&anexo_id={$item.anexo_id}&publicacao_id={$parameters.publicacao_id}">editar</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoAnexoExcluir&anexo_id={$item.anexo_id}&publicacao_id={$parameters.publicacao_id}">excluir</a></td>
					</tr>
				{foreachelse}
					<tr class="not_found">
						<td colspan="10">Nenhum anexo cadastrado nesta publicação</td>
					</tr>
				{/foreach}
			</tbody>
	</table>
{/capture}
{include file="includes/template.tpl"}