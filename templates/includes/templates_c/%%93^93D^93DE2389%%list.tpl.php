<?php /* Smarty version 2.6.14, created on 2013-06-10 07:14:37
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/admin_banner/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/home/daniel_com/danielribeiro.com/karinanork/templates/admin_banner/list.tpl', 21, false),)), $this); ?>
<?php ob_start(); ?>

	<h1>Listagem de banners cadastrados</h1>

	<a href="?module=admin_banner&action=admin_bannerAdd">Adicionar novo banner</a>
  
	<?php if ($this->_tpl_vars['banners']): ?>
		<table class="listing">
			<thead>
				<tr>
					<th>T&iacute;tulo</th>
					<th>Tipo</th>
					<th>Status</th>
					<th>Visualizacoes</th>
					<th>Clicks</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['banners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => "line1,line2"), $this);?>
">
						<td><?php echo $this->_tpl_vars['item']['titulo']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['tipo']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['views']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['clicks']; ?>
</td>
						<td><a href="?module=admin_banner&action=admin_bannerEdit&banner_id=<?php echo $this->_tpl_vars['item']['banner_id']; ?>
">editar</a></td>
						<td><a href="?module=admin_banner&action=admin_bannerDelete&banner_id=<?php echo $this->_tpl_vars['item']['banner_id']; ?>
">excluir</a></td>
					</tr>
				<?php endforeach; else: ?>
					<tr class="not_found">
						<td colspan="10">Nenhum banner encontrado</td>
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