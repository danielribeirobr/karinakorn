{capture name="content"}

	<h1>Listagem de banners cadastrados</h1>

	<a href="?module=admin_banner&action=admin_bannerAdd">Adicionar novo banner</a>
  
	{if $banners }
		<table class="listing">
			<thead>
				<tr>
					<th>T&iacute;tulo</th>
					<th>Tipo</th>
					<th>Status</th>
					<th>Visualizacoes</th>
					<th>Clicks</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$banners item=item}
					<tr class="{cycle values="line1,line2"}">
						<td>{$item.titulo}</td>
						<td>{$item.tipo}</td>
						<td>{$item.status}</td>
						<td>{$item.views}</td>
						<td>{$item.clicks}</td>
						<td><a href="?module=admin_banner&action=admin_bannerEdit&banner_id={$item.banner_id}">editar</a></td>
						<td><a href="?module=admin_banner&action=admin_bannerDelete&banner_id={$item.banner_id}">excluir</a></td>
					</tr>
				{foreachelse}
					<tr class="not_found">
						<td colspan="10">Nenhum banner encontrado</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}

{/capture}
{include file="includes/template.tpl"}