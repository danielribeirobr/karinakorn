{capture name="content"}
	<h1>Cadastro de banner</h1>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="module" id="module" value="admin_banner"/>
		<input type="hidden" name="action" id="action" value="admin_bannerSave"/>
		<input type="hidden" name="banner_id" id="banner_id" value="{$form.banner_id}"/>
		<fieldset>
			<legend>Dados principais do banner</legend>

			<label for="Tipo">Tipo</label>
			<select name="tipo" id="tipo">
				<option value="">--selecione--</option>
				<option value="texto" {if $form.tipo == 'texto'} selected {/if}>Texto</option>
				<option value="imagem" {if $form.tipo == 'imagem'} selected {/if}>Imagem</option>
			</select>
			{if $error.tipo}
				<div class="error">{$error.tipo}</div>
			{/if}
			<br/>

			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="{$form.titulo}"/>
			{if $error.titulo}
				<div class="error">{$error.titulo}</div>
			{/if}
			<br/>

			<label for="texto">Texto:</label>
			<textarea name="texto" id="texto">{$form.texto}</textarea>
			{if $error.texto}
				<div class="texto">{$error.texto}</div>
			{/if}
			<br/>

			<label for="arquivo">Arquivo:</label>
			<input type="file" name="arquivo" id="arquivo"/>
			{if $error.arquivo}
				<div class="error" style="margin-left: 60px;">{$error.arquivo}</div>
			{/if}
			<br/>

			{if $form.img}
				<br/><br/>
				<img src="{$appConfig.db_banners}{$form.banner_id}-{$form.img}" style="margin-left: 174px;"/>
				<br/>
			{/if}
			
			<label for="link">Link:</label>
			<input type="text" name="link" id="link" value="{$form.link}"/>
			{if $error.link}
				<div class="error">{$error.link}</div>
			{/if}
			<br/>
			
			<label for="status">Ativo:</label>
			<input type="checkbox" class="checkbox" name="status" id="status" value="1" {if $form.status} checked {/if}/>
			<br/>

			<label for="paginas">Páginas:</label>
			<select name="pagina[]" id="pagina" multiple>
				{foreach from=$paginas item=pagina}
					<option value="{$pagina.pagina}" {if $pagina.selecionada} selected {/if}>{$pagina.pagina}</option>
				{/foreach}
			</select>
			<span class="info">Para selecionar mais de um item, seguro a tecla "ctrl" enquanto clica nos itens</span>
			{if $error.pagina}
				<div class="error">{$error.pagina}</div>
			{/if}
			<br/>

			<input type="submit" value="Salvar" class="submit"/>
			<input type="button" value="Cancelar" class="submit2" onclick="document.location.href='?module=admin_banner'"/>
		</fieldset>
	</form>

{/capture}
{include file="includes/template.tpl"}