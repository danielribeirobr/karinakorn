<?php /* Smarty version 2.6.14, created on 2011-05-27 20:23:46
         compiled from /home/daniel/projetos/karinakorn/templates/admin_publicacao/imagens/form.tpl */ ?>
<?php ob_start(); ?>

	<h2>Imagem de <?php echo $this->_tpl_vars['publicacao']['titulo']; ?>
</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="<?php echo $this->_tpl_vars['form']['publicacao_id']; ?>
"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoImagemSalvar"/>
		<input type="hidden" name="imagem_id" id="imagem_id" value="<?php echo $this->_tpl_vars['form']['imagem_id']; ?>
"/>
		<fieldset>
			<legend>Dados da imagem</legend>
			<label for="titulo">T&iacute;tulo:</label>
			<input type="text" name="titulo" id="titulo" value="<?php echo $this->_tpl_vars['form']['titulo']; ?>
"/>
			<?php if ($this->_tpl_vars['error']['titulo']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['titulo']; ?>
</div>
			<?php endif; ?>
			<br/>

			<?php if (! $this->_tpl_vars['form']['imagem_id']): ?>
				<label for="imagem_tipo_id">Tipo:</label>
				<select name="imagem_tipo_id" id="imagem_tipo_id">
					<option value="">--Selecione--</option>
					<?php $_from = $this->_tpl_vars['form']['imagem_tipo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']['imagem_tipo_id']; ?>
" <?php if ($this->_tpl_vars['item']['imagem_tipo_id'] == $this->_tpl_vars['form']['imagem_tipo_id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['item']['tipo']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			<?php if ($this->_tpl_vars['error']['imagem_tipo_id']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['imagem_tipo_id']; ?>
</div>
			<?php endif; ?>
				<br/>
			<?php endif; ?>

			<label for="descricao">Descri&ccedil;&atilde;o:</label>
			<textarea name="descricao" id="descricao"><?php echo $this->_tpl_vars['form']['descricao']; ?>
</textarea>
			<?php if ($this->_tpl_vars['error']['descricao']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['descricao']; ?>
</div>
			<?php endif; ?>
			<br/>

			<?php if (! $this->_tpl_vars['form']['imagem_id']): ?>
				<label for="arquivo">Arquivo:</label>
				<input type="file" name="arquivo" id="arquivo"/>
				<?php if ($this->_tpl_vars['error']['arquivo']): ?>
					<div class="error" style="margin-left: 60px;"><?php echo $this->_tpl_vars['error']['arquivo']; ?>
</div>
				<?php endif; ?>
				<br/>
			<?php endif; ?>

			<input type="submit" value="Salvar" class="submit" style="width: 120px;"/>
			<input type="button" value="Voltar" class="submit2" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoImagemListar&publicacao_id=<?php echo $this->_tpl_vars['form']['publicacao_id']; ?>
';"/>

			<?php if ($this->_tpl_vars['form']['imagem_id']): ?>
				<br/><br/>
				<img src="<?php echo $this->_tpl_vars['appConfig']['db_imagens'];  echo $this->_tpl_vars['form']['arquivo']; ?>
" style="margin-left: 174px;"/>
			<?php endif; ?>

		</fieldset>
	</form>
<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>