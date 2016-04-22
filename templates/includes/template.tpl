<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="templates/includes/style.css" type="text/css"/>
<script language="javascript" src="templates/includes/jquery.js"></script>
<title>Karina Korn - &Aacute;rea administrativa</title>
</head>
<body>
	<div id="div_header">
		Karina Korn - Área administrativa
	</div>
	<div style="background: #d3232e; height: 5px;"></div>

	<div id="div_middle">

		{if $globals.user.user_id}
			<div id="div_menu">
				{if $globals.user.level.admin}
					<div class="menu">
						<ul id="menu_admin">
							<li><a href="?module=admin">Principal</a></li>
							<li><a href="?module=admin_publicacao&publicacao_tipo_id=16">Home</a></li>
							<li><a href="?module=admin_publicacao&publicacao_tipo_id=8">Perfil</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=1">Projetos</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=2">Mostras</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=9">Mídia</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=10">Vídeos</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=11">Dicas decoração</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=12">Responsabilidade social</a></li>
 							<li><a href="?module=admin_publicacao&publicacao_tipo_id=13">Personalidades</a></li>
							<li><a href="?module=admin_publicacao&publicacao_tipo_id=14">News</a></li>
							<li><a href="?module=admin_publicacao&publicacao_tipo_id=15">Agenda</a></li>
 							<li><a href="?module=admin_banner">Banners</a></li>
							<li><a href="?module=login&action=loginDoLogout">Sair</a></li>
						</ul>
					</div>
				{/if}
			</div>
		{/if}

		<div id="div_content">
			{$smarty.capture.content}
		</div>

		<div class="clear"></div>
	</div>

	<div id="div_footer">
		<p>
			Copyright © 2010 - Karina Korn - Todos os direitos reservados
		</p>
	</div>

</body>
</html>
