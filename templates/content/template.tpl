<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Karina Korn Arquitetura</title>
<link href="templates/source/css/estilos.css" rel="stylesheet" type="text/css"/>
<link href="templates/content/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="templates/includes/jquery.js"></script>
<style type="text/css">
{literal}
#bubble_arrow {padding:0px margin: 0px;}#bubble_sel {visibility:hidden; position:absolute; z-index: 9998}#bubble {opacity: .93; position:absolute; display:block; z-index: 9998; font-family: Lucida grande, arial, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: normal;}#bubble_cont{padding:7px 7px 7px 7px; z-index: 9998; -webkit-border-radius: 7px;}</style>
{/literal}
</head><body>
<table width="900" align="center" cellpadding="0" cellspacing="0" bgcolor="#404143">
  <tbody><tr>
    <td valign="top">&nbsp;</td>
    <td width="190" rowspan="3" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td align="center"><a href="sitemap.html" title="Mapa do Site" alt="Mapa do Site"><img src="templates/source/img/sitemap.jpg" width="170" height="28" border="0"></a></td>
      </tr>
      <tr>
        <td align="center"><a href="recomende.html" title="Recomende o site Karina Korn" alt="Recomende o site Karina Korn"><img src="templates/source/img/recomende.jpg" width="170" height="25" border="0"></a></td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="710" valign="top">
      <nobr>
        <span class="Textoczamenu1">
          <a href="?page=perfil" class="linkmenu{if $parameters.page != 'perfil'}1{else}2{/if}" title="Perfil" alt="Perfil">perfil</a>
          | <a href="?page=projetos" title="Projetos" class="linkmenu{if $parameters.page != 'projetos'}1{else}2{/if}" alt="Projetos">projetos</a>
          | <a href="?page=mostras" class="linkmenu{if $parameters.page != 'mostras'}1{else}2{/if}" title="Mostras" alt="Mostras">mostras</a>
          | <a href="?page=midia" class="linkmenu{if $parameters.page != 'midia'}1{else}2{/if}" title="Mídia" alt="Mídia">midia</a>
          | <a href="?page=videos" class="linkmenu{if $parameters.page != 'videos'}1{else}2{/if}" title="Vídeos" alt="Vídeos">videos</a>
          | <a href="?page=dicas_decoracao" class="linkmenu{if $parameters.page != 'dicas_decoracao'}1{else}2{/if}" title="Dicas de Decoração" alt="Dicas de Decoração">dicas de decoração</a>
          | <a href="?page=responsabilidade_social" class="linkmenu{if $parameters.page != 'responsabilidade_social'}1{else}2{/if}" title="Responsabilidade Social" alt="Responsabilidade Social">responsabilidade social</a>
          | <a href="?page=anuncie" class="linkmenu{if $parameters.page != 'anuncie'}1{else}2{/if}" title="Anuncie no Site Karina Korn" alt="Anuncie no Site Karina Korn">anuncie</a>
          | <a href="?page=fale_conosco" class="linkmenu{if $parameters.page != 'fale_conosco'}1{else}2{/if}" title="Fale com a Arquiteta Karina Korn" alt="Fale com a Arquiteta Karina Korn">fale conosco</a>
        </span>
      </nobr>
    </td>
  </tr>
  
  <tr>
    <td valign="top" class="td_main">    
	    {$smarty.capture.content}
    </td>
    <td valign="top" bgcolor="#000000">
		{include file="content/banners.tpl"}
	</td>
  </tr>
  <tr>
    <td height="40" align="center" bgcolor="#666666">Copyright © 2009 - Karina Korn - Todos os direitos reservados</td>
    <td align="center" bgcolor="#333333">design by <a href="http://www.nannydesign.com.br/" target="_blank" title="NannyDesign - ComunicaÃ§Ã£o Visual" alt="NannyDesign - ComunicaÃ§Ã£o Visual" class="linknotas">NannyDesign</a><br>
      webdeveloper by <a href="http://www.savaglia.com.br" target="_blank" title="Afonso Savaglia - Desenvolvedor Web" alt="Afonso Savaglia - Desenvolvedor Web" class="linknotas">Savaglia</a> </td>
  </tr>
</tbody></table>
</body></html>
