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
				<div class="Titulo">{$publicacao.titulo}</div>
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
            <td height="87" width="600" colspan="2"><img height="87" width="670" src="templates/source/img/faixaperson.jpg"></td>
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
          <tr>
            <td bgcolor="#993366" class="Titulo_pto" colspan="2">Personalidades do mundo  da Arquitetura e Decoração </td>
          </tr>
          <tr>
            <td width="190">&nbsp;</td>
            <td width="600">&nbsp;</td>
          </tr>

		  {foreach from=$publicacoes item=item}
			  <tr>
				<td>
					{foreach from=$item.IMAGENS item=item_img key=key}
						{if $item_img.tag == 'IMG_PEQUENA'}
							<img src="db_imagens/{$item_img.arquivo}"/>
						{/if}
					{/foreach}
				</td>
				<td class="Td_dicas" rowspan="2"><a class="linkpersona" href="personalidades.html">{$item.descricao|strip_tags|truncate:600}</a></td>
			  </tr>
			  <tr>
				<td bgcolor="#000000" align="center">{$item.titulo}</td>
				</tr>
			  <tr>
				<td align="center">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
		  {/foreach}

          <tr>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

        </tbody></table>



		</td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
    </tbody></table>

{/capture}
{include file="content/template.tpl"}