<?php /* Smarty version 2.6.14, created on 2013-06-11 06:37:49
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/admin_banner/form.tpl */ ?>
<?php ob_start(); ?>
	<h1>Cadastro de banner</h1>

	<form method="post" class="form" enctype="multipart/form-data">
		<input type="hidden" name="module" id="module" value="admin_banner"/>
		<input type="hidden" name="action" id="action" value="admin_bannerSave"/>
		<input type="hidden" name="banner_id" id="banner_id" value="<?php echo $this->_tpl_vars['form']['banner_id']; ?>
"/>
		<fieldset>
			<legend>Dados principais do banner</legend>

			<label for="Tipo">Tipo</label>
			<select name="tipo" id="tipo">
				<option value="">--selecione--</option>
				<option value="texto" <?php if ($this->_tpl_vars['form']['tipo'] == 'texto'): ?> selected <?php endif; ?>>Texto</option>
				<option value="imagem" <?php if ($this->_tpl_vars['form']['tipo'] == 'imagem'): ?> selected <?php endif; ?>>Imagem</option>
			</select>
			<?php if ($this->_tpl_vars['error']['tipo']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['tipo']; ?>
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

			<label for="texto">Texto:</label>
			<textarea name="texto" id="texto"><?php echo $this->_tpl_vars['form']['texto']; ?>
</textarea>
			<?php if ($this->_tpl_vars['error']['texto']): ?>
				<div class="texto"><?php echo $this->_tpl_vars['error']['texto']; ?>
</div>
			<?php endif; ?>
			<br/>

			<label for="arquivo">Arquivo:</label>
			<input type="file" name="arquivo" id="arquivo"/>
			<?php if ($this->_tpl_vars['error']['arquivo']): ?>
				<div class="error" style="margin-left: 60px;"><?php echo $this->_tpl_vars['error']['arquivo']; ?>
</div>
			<?php endif; ?>
			<br/>

			<?php if ($this->_tpl_vars['form']['img']): ?>
				<br/><br/>
				<img src="<?php echo $this->_tpl_vars['appConfig']['db_banners'];  echo $this->_tpl_vars['form']['banner_id']; ?>
-<?php echo $this->_tpl_vars['form']['img']; ?>
" style="margin-left: 174px;"/>
				<br/>
			<?php endif; ?>
			
			<label for="link">Link:</label>
			<input type="text" name="link" id="link" value="<?php echo $this->_tpl_vars['form']['link']; ?>
"/>
			<?php if ($this->_tpl_vars['error']['link']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['link']; ?>
</div>
			<?php endif; ?>
			<br/>
			
			<label for="status">Ativo:</label>
			<input type="checkbox" class="checkbox" name="status" id="status" value="1" <?php if ($this->_tpl_vars['form']['status']): ?> checked <?php endif; ?>/>
			<br/>

			<label for="paginas">Páginas:</label>
			<select name="pagina[]" id="pagina" multiple>
				<?php $_from = $this->_tpl_vars['paginas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pagina']):
?>
					<option value="<?php echo $this->_tpl_vars['pagina']['pagina']; ?>
" <?php if ($this->_tpl_vars['pagina']['selecionada']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['pagina']['pagina']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
			<span class="info">Para selecionar mais de um item, seguro a tecla "ctrl" enquanto clica nos itens</span>
			<?php if ($this->_tpl_vars['error']['pagina']): ?>
				<div class="error"><?php echo $this->_tpl_vars['error']['pagina']; ?>
</div>
			<?php endif; ?>
			<br/>

			<input type="submit" value="Salvar" class="submit"/>
			<input type="button" value="Cancelar" class="submit2" onclick="document.location.href='?module=admin_banner'"/>
		</fieldset>
	</form>

<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>