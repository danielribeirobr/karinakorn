<table align="center" cellpadding="0" cellspacing="0">
      <tbody>
		{foreach from=$banners item=item}
		  {if $item.tipo == 'imagem'}
			  <tr>
				<td class="td_bannerhome">
					<table cellpadding="0" cellspacing="0" class="table_bannerhome">
						<tbody>
							<tr>
								<td><a href="?module=content&action=bannerClick&banner_id={$item.banner_id}" target="_blank" title="{$item.titulo}" alt="{$item.titulo}"><img src="db_banners/{$item.banner_id}-{$item.img}" border="0"></a></td>
							</tr>
						</tbody>
					</table>
				</td>
			  </tr>
		  {/if}

		  {if $item.tipo == 'texto'}
			  <tr>
				<td class="td_bannerhome">
					<table cellpadding="0" cellspacing="0" class="table_bannerhome">
					  <tbody>
						  <tr>
							<td>
								<a href="?module=content&action=bannerClick&banner_id={$item.banner_id}" target="_blank" title="{$item.titulo}" alt="{$item.titulo}" class="linkmenu2">{$item.titulo}</a><br>
								{$item.texto|nl2br}
								<a href="?module=content&action=bannerClick&banner_id={$item.banner_id}" target="_blank" title="{$item.titulo}" alt="{$item.titulo}" class="linkmenu2">{$item.link}</a>
							</td>
						</tr>
					  </tbody>
					</table>
				</td>
			  </tr>
		  {/if}
	  {/foreach}
    </tbody>
</table>