<?php /* Smarty version 2.6.14, created on 2011-05-27 21:03:02
         compiled from /home/daniel/projetos/karinakorn/templates/admin_publicacao/anexo/form.tpl */ ?>
<?php ob_start(); ?>
	<h2>Anexo de <?php echo $this->_tpl_vars['publicacao']['titulo']; ?>
</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="<?php echo $this->_tpl_vars['form']['publicacao_id']; ?>
"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoAnexoSalvar"/>
		<input type="hidden" name="anexo_id" id="anexo_id" value="<?php echo $this->_tpl_vars['form']['anexo_id']; ?>
"/>
		<fieldset>
			<legend>Dados do anexo</legend>
			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="<?php echo $this->_tpl_vars['form']['titulo']; ?>
"/>
			<?php if ($this->_tpl_vars['error']['titulo']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['titulo']; ?>
</div>
			<?php endif; ?>
			<br/>

			<?php if ($this->_tpl_vars['error']['anexo_categoria_id']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['anexo_categoria_id']; ?>
</div>
			<?php endif; ?>
			<br/>

			<label for="arquivo">Arquivo:</label>
			<?php if (! $this->_tpl_vars['form']['anexo_id']): ?>
				<input type="file" name="arquivo" id="arquivo"/>
				<?php if ($this->_tpl_vars['error']['arquivo']): ?>
					<div class="error" style="margin-left: 60px;"><?php echo $this->_tpl_vars['error']['arquivo']; ?>
</div>
				<?php endif; ?>
			<?php else: ?>
				<a href="?module=admin_publicacao&action=downloadAnexo&anexo_id=<?php echo $this->_tpl_vars['form']['anexo_id']; ?>
">Download</a>
			<?php endif; ?>
			<br/><br/>

			<input type="submit" value="Salvar" class="submit" style="width: 120px;"/>
			<input type="button" value="Voltar" class="submit2" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoAnexoListar&publicacao_id=<?php echo $this->_tpl_vars['form']['publicacao_id']; ?>
';"/>
		</fieldset>
	</form>
<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>