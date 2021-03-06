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

		$('#p_ano').change(function(){
			$('#p_id').val(null);
			submitForm();
		});

		$('#p_id').change(function(){
			submitForm();
		});
	});

	function submitForm()
	{
		url = '?page=projetos&p_cat=' + $('#p_cat').val() + '&p_ano=' + $('#p_ano').val();
		if( $('#p_id').val() != null ) {
			url += '&p_id=' + $('#p_id').val();
		}
		document.location.href = url;
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
				  <li class="li"><a href="?page=projetos&p_cat={$item}" class="linkmenu{if $parameters.p_cat != $item}1{else}2{/if}" title="Projetos Karina Korn - {$item}" alt="Projetos {$item}">{$item}</a></li>
			   {/foreach}
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border"><table width="171" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Projetos {$parameters.p_cat}</td>
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
				<select id="p_id" class="form">
					{foreach from=$publicacoes item=item}
						<option value="{$item.publicacao_id}" {if $item.publicacao_id == $parameters.p_id} selected {/if}>{$item.titulo}</option>
					{/foreach}
				</select>
			</td>
          </tr>

          <tr>
            <td><div style="overflow-y:auto; height:220px; width:171px; margin-top: 20px;">
				<ul class="galeria">
					{foreach from=$publicacao.IMAGENS item=item key=key}
						<li>
							<img src="?module=content&action=showImg&imagem_id={$item.imagem_id}&l=50&a=50" rel="{$item.imagem_id}" class="thumb_img {if $key==0}thumb_img_active{/if}">
						</li>
					{/foreach}
				</ul>
            </div></td>
          </tr>
        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">

		{foreach from=$publicacao.IMAGENS item=item key=key}
			<div class="imagem_public" id="imagem_public_{$item.imagem_id}" style="display: {if $key == 0}block{else}none{/if};">
				<div>
					<img src="db_imagens/{$item.arquivo}"/>
				</div>
				<div style="margin-top: 20px;">
					{$item.titulo}
				</div>
			</div>
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
            <td><img src="templates/source/img/faixaprojetos.jpg" width="670" height="87"></td>
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