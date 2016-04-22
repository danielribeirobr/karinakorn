<?php /* Smarty version 2.6.14, created on 2011-05-27 14:43:10
         compiled from /home/daniel/projetos/karinakorn/templates/admin_publicacao/form.tpl */ ?>
<?php ob_start(); ?>
	<script language="javascript" src="templates/includes/fckeditor/fckeditor.js"></script>
	<?php echo '
		<script language="javascript">
			$(function(){
				$(\'.htmlarea\').each(function(index, element){
					var oFCKeditor = new FCKeditor($(element).attr(\'id\')) ;
					oFCKeditor.BasePath = "templates/includes/fckeditor/" ;
					oFCKeditor.ReplaceTextarea();
				});
			});

			function saveAndGoto( action )
			{
				$(\'input[name=afterSave]\').val(action);
				$(\'form\').submit();
			}
		</script>
	'; ?>

	<h1>Cadastro da publicação</h1>

	<input type="button" value="Imagens" onclick="saveAndGoto('admin_publicacaoImagemListar');"/>
	<input type="button" value="Detalhes" onclick="saveAndGoto('admin_publicacaoDetalhesEditar');"/>
	<input type="button" value="Anexos" onclick="saveAndGoto('admin_publicacaoAnexoListar');"/>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoSave"/>
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="<?php echo $this->_tpl_vars['form']['publicacao_id']; ?>
"/>
		<input type="hidden" name="publicacao_tipo_id" id="publicacao_tipo_id" value="<?php echo $this->_tpl_vars['form']['publicacao_tipo_id']; ?>
"/>
		<input type="hidden" name="afterSave"/>
		<fieldset>
			<legend>Dados principais da publicação</legend>

			<label for="identificacao">Identifica&ccedil;&atilde;o:</label>
			<input type="text" name="identificacao" id="identificacao" value="<?php echo $this->_tpl_vars['form']['identificacao']; ?>
"/>
			<?php if ($this->_tpl_vars['error']['identificacao']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['identificacao']; ?>
</div>
			<?php endif; ?>
			<br/>

			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="<?php echo $this->_tpl_vars['form']['titulo']; ?>
"/>
			<?php if ($this->_tpl_vars['error']['titulo']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['titulo']; ?>
</div>
			<?php endif; ?>
			<br/>

			  <label for="descricao">Texto:</label>
			  <textarea name="descricao" id="descricao" class="htmlarea"><?php echo $this->_tpl_vars['form']['descricao']; ?>
</textarea>
			  <?php if ($this->_tpl_vars['error']['descricao']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['descricao']; ?>
</div>
			  <?php endif; ?>
			  <br/>

			<input type="submit" value="Salvar" class="submit"/>
			<input type="button" value="Cancelar" class="submit2" onclick="document.location.href='?module=admin_publicacao&publicacao_tipo_id=<?php echo $this->_tpl_vars['form']['publicacao_tipo_id']; ?>
';"/>
		</fieldset>
	</form>

<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>