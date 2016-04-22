<?php /* Smarty version 2.6.14, created on 2011-05-27 14:43:23
         compiled from /home/daniel/projetos/karinakorn/templates/admin_publicacao/detalhes/form.tpl */ ?>
<?php ob_start(); ?>

	<h2>Detalhamento de <?php echo $this->_tpl_vars['publicacao']['titulo']; ?>
</h2>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="publicacao_id" id="publicacao_id" value="<?php echo $this->_tpl_vars['publicacao']['publicacao_id']; ?>
"/>
		<input type="hidden" name="module" id="module" value="admin_publicacao"/>
		<input type="hidden" name="action" id="action" value="admin_publicacaoDetalhesSalvar"/>
		<fieldset>
			<legend>Dados detalhados da publicação</legend>
			<?php $_from = $this->_tpl_vars['campos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['campo']):
?>
				<label for="titulo"><?php echo $this->_tpl_vars['campo']['campo']; ?>
:</label>
				<?php $this->assign('campo_id', $this->_tpl_vars['campo']['campo_id']); ?>
				<?php $this->assign('var_name', "campo_".($this->_tpl_vars['campo_id'])); ?>
				<?php $this->assign('value', $this->_tpl_vars['form'][$this->_tpl_vars['var_name']]); ?>
				<?php if ($this->_tpl_vars['campo']['campo_tipo'] == 'text'): ?>
					<input type="text" name="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
" id="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
"/>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['campo']['campo_tipo'] == 'combo'): ?>
					<select name="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
" id="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
">
						<option value="">-- selecione --</option>
						<?php $_from = $this->_tpl_vars['campo']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
							<option value="<?php echo $this->_tpl_vars['v']; ?>
" <?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['v']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['campo']['campo_tipo'] == 'textarea'): ?>
					<textarea name="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
" id="campo_<?php echo $this->_tpl_vars['campo']['campo_id']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</textarea>
				<?php endif; ?>
				<br/>
			<?php endforeach; endif; unset($_from); ?>
			<input type="submit" class="submit" value="Salvar"/>
			<input type="button" class="submit2" value="Voltar" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id=<?php echo $this->_tpl_vars['publicacao']['publicacao_id']; ?>
';"/>
		</fieldset>
	</form>
<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>