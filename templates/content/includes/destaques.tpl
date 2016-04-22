<table width="670" align="center" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#86B300" class="Titulo_pto">Dicas de Decoração </td>
      </tr>
      <tr>
        <td align="center">
			{foreach from=$destaques.DICAS_DECORACAO.IMAGENS item=item}
				{if $item.tag == 'IMG_PEQUENA'}
					<img src="db_imagens/{$item.arquivo}">
				{/if}
			{/foreach}
		</td>
      </tr>      
      <tr>
        <td height="18" align="center" bgcolor="#000000">{$destaques.DICAS_DECORACAO.titulo}</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="dicasdecoracao.html" title="Dicas de Decoração" alt="Dicas de Decoração" class="linkdicas">
				{$destaques.DICAS_DECORACAO.descricao|strip_tags|truncate:200}</a>
		</td>
      </tr>
    </tbody></table></td>
    <td width="50">&nbsp;</td>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#FF6600" class="Titulo_pto">Agenda</td>
      </tr>
      <tr>
        <td align="center">
			{foreach from=$destaques.AGENDA.IMAGENS item=item}
				{if $item.tag == 'IMG_PEQUENA'}
					<img src="db_imagens/{$item.arquivo}">
				{/if}
			{/foreach}
		</td>
      </tr>      
      <tr>
        <td height="18" align="center" bgcolor="#000000">{$destaques.AGENDA.titulo}</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="agenda.html" title="Agenda de Eventos" alt="Agenda de Eventos" class="linkagenda">{$destaques.AGENDA.descricao|strip_tags|truncate:200}</a></td>
      </tr>
    </tbody></table></td>
    <td width="50">&nbsp;</td>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#993366" class="Titulo_pto">Personalidades</td>
      </tr>
      <tr>
        <td align="center">
			{foreach from=$destaques.PERSONALIDADES.IMAGENS item=item}
				{if $item.tag == 'IMG_PEQUENA'}
					<img src="db_imagens/{$item.arquivo}">
				{/if}
			{/foreach}
		</td>
      </tr>
      <tr>
        <td height="18" align="center" bgcolor="#000000">{$destaques.PERSONALIDADES.titulo}</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="personalidades.html" title="Personalidades" alt="Personalidades" class="linkpersona">{$destaques.PERSONALIDADES.descricao|strip_tags|truncate:200}</a></td>
      </tr>
    </tbody></table></td>
  </tr>
</tbody></table>