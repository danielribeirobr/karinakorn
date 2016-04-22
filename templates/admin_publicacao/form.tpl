{capture name="content"}
	<script language="javascript" src="templates/includes/fckeditor/fckeditor.js"></script>
	{literal}
		<script language="javascript">
			$(function(){
				$('.htmlarea').each(function(index, element){
					var oFCKeditor = new FCKeditor($(element).attr('id')) ;
					oFCKeditor.BasePath = "templates/includes/fckeditor/" ;
					oFCKeditor.ReplaceTextarea();
				});
			});

			function saveAndGoto( action )
			{
				$('input[name=afterSave]').val(action);
				$('form').submit();
			}
		</script>
	{/literal}
	<h1>Cadastro da publicação</h1>

	<input type="button" value="Imagens" onclick="saveAndGoto('admin_publicacaoImagemListar');"/>
	<input type="button" value="Detalhes" onclick="saveAndGoto('admin_publicacaoDetalhesEditar');"/>
	<input type="button" value="Anexos" onclick="saveAndGoto('admin_publicacaoAnexoListar');"/>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoSave"/>
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="{$form.publicacao_id}"/>
		<input type="hidden" name="publicacao_tipo_id" id="publicacao_tipo_id" value="{$form.publicacao_tipo_id}"/>
		<input type="hidden" name="afterSave"/>
		<fieldset>
			<legend>Dados principais da publicação</legend>

			<label for="identificacao">Identifica&ccedil;&atilde;o:</label>
			<input type="text" name="identificacao" id="identificacao" value="{$form.identificacao}"/>
			{if $error.identificacao}
				<div class="error">{$error.identificacao}</div>
			{/if}
			<br/>

			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="{$form.titulo}"/>
			{if $error.titulo}
				<div class="error">{$error.titulo}</div>
			{/if}
			<br/>

			  <label for="descricao">Texto:</label>
			  <textarea name="descricao" id="descricao" class="htmlarea">{$form.descricao}</textarea>
			  {if $error.descricao}
				<div class="error">{$error.descricao}</div>
			  {/if}
			  <br/>

			<input type="submit" value="Salvar" class="submit"/>
			<input type="button" value="Cancelar" class="submit2" onclick="document.location.href='?module=admin_publicacao&publicacao_tipo_id={$form.publicacao_tipo_id}';"/>
		</fieldset>
	</form>

{/capture}
{include file="includes/template.tpl"}