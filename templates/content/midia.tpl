{capture name="content"}
{literal}
<script type="text/javascript">
	$(function(){
		$('.thumb_img').click(function() {
			$('.thumb_img').removeClass('thumb_img_active');
			$(this).addClass('thumb_img_active');
			$('.imagem_public').hide();
			$('#imagem_public_' + $(this).attr('rel')).fadeIn();
		});

		$('#p_mes').change(function(){
			$('#p_id').val(null);
			submitForm();
		});

		$('#p_id').change(function(){
			submitForm();
		});
	});

	function submitForm()
	{
		url = '?page=midia&p_cat=' + $('#p_cat').val() + '&p_ano=' + $('#p_ano').val() + '&p_mes=' + $('#p_mes').val();
		if( $('#p_id').val() ) {
			url += '&p_id=' + $('#p_id').val();
		}
		document.location.href =  url;
	}
</script>
{/literal}
<input type="hidden" id="p_cat" value="{$parameters.p_cat}"/>
<table width="710" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="113" valign="top" bgcolor="#000000"><table width="113" align="center" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td><img src="templates/source/img/logo.jpg" width="113" height="233"></td>
          </tr>
          <tr>
            <td>
			  {foreach from=$categorias item=item}
				  <li class="li"><a href="?page=midia&p_cat={$item}" class="linkmenu{if $parameters.p_cat != $item}1{else}2{/if}" title="Projetos Karina Korn - {$item}" alt="Projetos {$item}">{$item}</a></li>
			  {/foreach}
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border"><table width="171" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Mídia {$parameters.p_cat}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<select id="p_ano" class="form">
					{foreach from=$anos item=item}
						<option value="{$item}" {if $item == $parameters.p_ano} selected {/if}>{$item}</option>
					{/foreach}
				</select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<select id="p_mes" class="form">
					{foreach from=$meses item=item}
						<option value="{$item}" {if $item == $parameters.p_mes} selected {/if}>{$item}</option>
					{/foreach}
				</select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<select id="p_id" class="form">
					{foreach from=$publicacoes item=item}
						<option value="{$item.publicacao_id}" {if $item.publicacao_id == $parameters.p_id} selected {/if}>{$item.titulo}</option>
					{/foreach}
				</select>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<table width="80" cellpadding="0" cellspacing="0">
					<tr>
						<td class="fotinhosbox">
							{foreach from=$publicacao.IMAGENS item=item key=key}
								{if $item.tag == 'IMG_DESTAQUE'}
									<img src="db_imagens/{$item.arquivo}"/>
								{/if}
							{/foreach}
						</td>
					</tr>
				</table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">			
			{foreach from=$publicacao.IMAGENS item=item key=key}
				{if $item.tag == 'PDF'}
				<a href="?module=content&action=downloadAnexo&anexo_id={$publicacao.ANEXOS.0.anexo_id}"><img src="db_imagens/{$item.arquivo}" border="0"/></a>
				{/if}
			{/foreach}
		</td>
      </tr>

      <tr>
        <td colspan="3" align="right" bgcolor="#000000" class="line2">&nbsp;</td>
      </tr>
      {include file="content/includes/links_inferior_topo.tpl"}
      <tr>
        <td colspan="3"><table width="670" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td><img src="templates/source/img/faixamidia.jpg" width="670" height="87"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="line">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>{include file="content/includes/destaques.tpl"}</td>
          </tr>
          {include file="content/includes/publicacoes_midia.tpl"}
        </tbody></table></td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
    </tbody></table>

{/capture}
{include file="content/template.tpl"}