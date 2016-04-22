<?php /* Smarty version 2.6.14, created on 2011-05-18 10:43:46
         compiled from content/banners.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'content/banners.tpl', 26, false),)), $this); ?>
<table align="center" cellpadding="0" cellspacing="0">
      <tbody>
		<?php $_from = $this->_tpl_vars['banners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		  <?php if ($this->_tpl_vars['item']['tipo'] == 'imagem'): ?>
			  <tr>
				<td class="td_bannerhome">
					<table cellpadding="0" cellspacing="0" class="table_bannerhome">
						<tbody>
							<tr>
								<td><a href="?module=content&action=bannerClick&banner_id=<?php echo $this->_tpl_vars['item']['banner_id']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['item']['titulo']; ?>
" alt="<?php echo $this->_tpl_vars['item']['titulo']; ?>
"><img src="db_banners/<?php echo $this->_tpl_vars['item']['banner_id']; ?>
-<?php echo $this->_tpl_vars['item']['img']; ?>
" border="0"></a></td>
							</tr>
						</tbody>
					</table>
				</td>
			  </tr>
		  <?php endif; ?>

		  <?php if ($this->_tpl_vars['item']['tipo'] == 'texto'): ?>
			  <tr>
				<td class="td_bannerhome">
					<table cellpadding="0" cellspacing="0" class="table_bannerhome">
					  <tbody>
						  <tr>
							<td>
								<a href="?module=content&action=bannerClick&banner_id=<?php echo $this->_tpl_vars['item']['banner_id']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['item']['titulo']; ?>
" alt="<?php echo $this->_tpl_vars['item']['titulo']; ?>
" class="linkmenu2"><?php echo $this->_tpl_vars['item']['titulo']; ?>
</a><br>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['texto'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

								<a href="?module=content&action=bannerClick&banner_id=<?php echo $this->_tpl_vars['item']['banner_id']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['item']['titulo']; ?>
" alt="<?php echo $this->_tpl_vars['item']['titulo']; ?>
" class="linkmenu2"><?php echo $this->_tpl_vars['item']['link']; ?>
</a>
							</td>
						</tr>
					  </tbody>
					</table>
				</td>
			  </tr>
		  <?php endif; ?>
	  <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>