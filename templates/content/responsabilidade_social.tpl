{capture name="content"}
<table width="710" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="113" valign="top" bgcolor="#000000"><table width="113" align="center" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td><img src="templates/source/img/logo.jpg" width="113" height="233"></td>
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border">
			{foreach from=$publicacao.IMAGENS item=item key=key}
				{if $item.tag == 'IMG_DESTAQUE'}
					<img src="db_imagens/{$item.arquivo}"/>
				{/if}
			{/foreach}
		</td>
        <td width="406" align="center" bgcolor="#000000">
			<div style="overflow-y:auto; height:330px; width:400px; margin: 5px; margin-top: 20px; text-align: left;">
				<div>{$publicacao.descricao}</div>
			</div>
		</td>
      </tr>

      <tr>
        <td colspan="3" align="right" bgcolor="#000000" class="line2">&nbsp;</td>
      </tr>
      {include file="content/includes/links_inferior_topo.tpl"}
      <tr>
        <td colspan="3">

			<table cellspacing="0" cellpadding="0" align="center" width="670">
			  <tbody><tr>
				<td height="87" colspan="2"><img height="87" width="670" src="templates/source/img/faixarespsocial.jpg"></td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td class="line" colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>


			  {foreach from=$publicacoes item=item}
				  <tr>
					<td bgcolor="#cc0000" class="Titulo_pto" colspan="2">{$item.titulo}</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <tr>
				  <tr>
					<td colspan="2" align="center">
						{foreach from=$item.IMAGENS item=item_img key=key}
							{if $item_img.tag == 'CATALOGO'}
								<img src="db_imagens/{$item_img.arquivo}" style="padding: 8px 30px;"/>
							{/if}
						{/foreach}
					</td>
				  </tr>
				  </tr>
				  <tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				  </tr>
				  <tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				  </tr>
			  {/foreach}


			</tbody></table>

		</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
    </tbody></table>

{/capture}
{include file="content/template.tpl"}