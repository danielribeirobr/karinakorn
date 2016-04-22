<?php /* Smarty version 2.6.14, created on 2011-05-18 10:43:46
         compiled from content/includes/destaques.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'content/includes/destaques.tpl', 21, false),array('modifier', 'truncate', 'content/includes/destaques.tpl', 21, false),)), $this); ?>
<table width="670" align="center" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#86B300" class="Titulo_pto">Dicas de Decoração </td>
      </tr>
      <tr>
        <td align="center">
			<?php $_from = $this->_tpl_vars['destaques']['DICAS_DECORACAO']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_PEQUENA'): ?>
					<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
">
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</td>
      </tr>      
      <tr>
        <td height="18" align="center" bgcolor="#000000"><?php echo $this->_tpl_vars['destaques']['DICAS_DECORACAO']['titulo']; ?>
</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="dicasdecoracao.html" title="Dicas de Decoração" alt="Dicas de Decoração" class="linkdicas">
				<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['destaques']['DICAS_DECORACAO']['descricao'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</a>
		</td>
      </tr>
    </tbody></table></td>
    <td width="50">&nbsp;</td>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#FF6600" class="Titulo_pto">Agenda</td>
      </tr>
      <tr>
        <td align="center">
			<?php $_from = $this->_tpl_vars['destaques']['AGENDA']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_PEQUENA'): ?>
					<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
">
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</td>
      </tr>      
      <tr>
        <td height="18" align="center" bgcolor="#000000"><?php echo $this->_tpl_vars['destaques']['AGENDA']['titulo']; ?>
</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="agenda.html" title="Agenda de Eventos" alt="Agenda de Eventos" class="linkagenda"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['destaques']['AGENDA']['descricao'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</a></td>
      </tr>
    </tbody></table></td>
    <td width="50">&nbsp;</td>
    <td width="190" valign="top"><table width="190" align="center" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td bgcolor="#993366" class="Titulo_pto">Personalidades</td>
      </tr>
      <tr>
        <td align="center">
			<?php $_from = $this->_tpl_vars['destaques']['PERSONALIDADES']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_PEQUENA'): ?>
					<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
">
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</td>
      </tr>
      <tr>
        <td height="18" align="center" bgcolor="#000000"><?php echo $this->_tpl_vars['destaques']['PERSONALIDADES']['titulo']; ?>
</td>
      </tr>
      <tr>
        <td height="18" align="center" class="Textonotas"><a href="personalidades.html" title="Personalidades" alt="Personalidades" class="linkpersona"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['destaques']['PERSONALIDADES']['descricao'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</a></td>
      </tr>
    </tbody></table></td>
  </tr>
</tbody></table>