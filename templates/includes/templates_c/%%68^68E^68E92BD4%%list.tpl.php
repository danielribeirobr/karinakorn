<?php /* Smarty version 2.6.14, created on 2012-10-30 06:03:15
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/admin_publicacao/imagens/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/home/daniel_com/danielribeiro.com/karinanork/templates/admin_publicacao/imagens/list.tpl', 17, false),)), $this); ?>
<?php ob_start(); ?>
	<h2>Imagens de <?php echo $this->_tpl_vars['publicacao']['titulo']; ?>
</h2>

	<input type="button" value="voltar" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoEdit&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
'"/>
	<input type="button" value="adicionar imagem" onclick="document.location.href='?module=admin_publicacao&action=admin_publicacaoImagemNovo&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
'"/>
	<table class="listing">
			<thead>
				<tr>
					<th>Tipo</th>
					<th>T&iacute;tulo</th>
					<th colspan="2">Ordem</th>
					<th colspan="2">Acoes</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['imagens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => "line1,line2"), $this);?>
">
						<td><?php echo $this->_tpl_vars['item']['imagem_tipo']; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']['titulo']; ?>
</td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemSetOrder&imagem_id=<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
&direction=up">Subir</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemSetOrder&imagem_id=<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
&direction=down">Descer</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemAbrir&imagem_id=<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
">editar</a></td>
						<td><a href="?module=admin_publicacao&action=admin_publicacaoImagemExcluir&imagem_id=<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
&publicacao_id=<?php echo $this->_tpl_vars['parameters']['publicacao_id']; ?>
">excluir</a></td>
					</tr>
				<?php endforeach; else: ?>
					<tr class="not_found">
						<td colspan="10">Nenhuma imagem cadastrada nesta publicação</td>
					</tr>
				<?php endif; unset($_from); ?>
			</tbody>
	</table>
<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>