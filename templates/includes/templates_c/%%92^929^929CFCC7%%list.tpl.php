<?php /* Smarty version 2.6.14, created on 2012-10-30 05:51:04
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/admin_publicacao/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/home/daniel_com/danielribeiro.com/karinanork/templates/admin_publicacao/list.tpl', 31, false),)), $this); ?>
<?php ob_start(); ?>

	<h1>Listagem de publicações do tipo: <?php echo $this->_tpl_vars['publicacao_tipo']['tipo']; ?>
</h1>

	<a href="?module=admin_publicacao&action=admin_publicacaoAdd&publicacao_tipo_id=<?php echo $this->_tpl_vars['publicacao_tipo']['publicacao_tipo_id']; ?>
">Adicionar nova publicação</a>
  
  <!--
	<form class="form" method="post">
		<fieldset>
			<legend>Buscar obras</legend>
			<label for="identificacao">Identifica&ccedil;&atilde;o:</label>
			<input type="text" id="identificacao" name="identificacao" value="<?php echo $this->_tpl_vars['form']['identificacao']; ?>
"/>
			<input type="submit" value="listar" class="button"/>
			[<a href="?module=admin_publicacao&todos=1">listar todos</a>]
		</fieldset>
	</form>
  -->

	<?php if ($this->_tpl_vars['publicacoes']): ?>
		<table class="listing">
			<thead>
				<tr>
					<th>Identifica&ccedil;&atilde;o</th>
					<th>T&iacute;tulo</th>
					<th colspan="2">Ordem</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['publicacoes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => "line1,line2"), $this);?>
">
						<td><?php echo $this->_tpl_vars['item']['identificacao']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['titulo']; ?>
</td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoSetOrder&publicacao_id=<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
&direction=down">Subir</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoSetOrder&publicacao_id=<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
&direction=up">Descer</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id=<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
">editar</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoDelete&publicacao_id=<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
">excluir</a></td>
					</tr>
				<?php endforeach; else: ?>
					<tr class="not_found">
						<td colspan="10">Nenhuma publicação encontrada</td>
					</tr>
				<?php endif; unset($_from); ?>
			</tbody>
		</table>
	<?php endif; ?>

<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>