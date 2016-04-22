<?php /* Smarty version 2.6.14, created on 2011-05-27 11:47:26
         compiled from /home/daniel/projetos/karinakorn/templates/admin/admin.tpl */ ?>
<?php ob_start(); ?>
	<h1>&Aacute;rea Administrativa</h1>
	<p>Bem vindo a &aacute;rea administrativa da Karina Korn</p>
	<p style="height: 70px;">Clique nos itens no menu ao lado.</p>
<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>