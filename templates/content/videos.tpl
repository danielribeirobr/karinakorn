{capture name="content"}
<table width="710" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="113" valign="top" bgcolor="#000000"><table width="113" align="center" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td><img src="templates/source/img/logo.jpg" width="113" height="233"></td>
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border"><table width="171" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Videos</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="Titulo">
				{$publicacao.titulo}
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
		  <tr class="Textomain">
            <td>{$publicacao.descricao}</td>
          </tr>

        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">
			{$publicacao.CAMPOS.VIDEO}
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
            <td height="87" colspan="3"><img height="87" width="670" src="templates/source/img/faixavideos.jpg"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td class="line" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#cc0000" class="Titulo_pto" colspan="3">Galeria de Vídeos </td>
          </tr>


		  {foreach from=$publicacoes item=item}
			  <tr>
				<td class="Titulo_pto">&nbsp;</td>
				<td bgcolor="#000000" width="191" class="border">&nbsp;</td>
				<td class="Titulo_pto">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="93">&nbsp;</td>
				<td bgcolor="#000000" class="border"><table cellspacing="0" cellpadding="0" align="center" width="171">
				  <tbody><tr>
					<td class="Textomain">{$item.titulo}</td>
				  </tr>
				</tbody></table></td>
				<td align="center" width="386">
					{foreach from=$item.IMAGENS item=item_img key=key}
						{if $item_img.tag == 'IMAGEM_VIDEO'}
						<a href="?page=videos&p_id={$item.publicacao_id}"><img src="db_imagens/{$item_img.arquivo}" border="0"/></a>
						{/if}
					{/foreach}
				</td>
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