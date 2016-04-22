<?php /* Smarty version 2.6.14, created on 2012-10-30 05:44:07
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/content/mostras.tpl */ ?>
<?php ob_start();  echo '
<script type="text/javascript">
	$(function(){
		$(\'.thumb_img\').click(function() {
			$(\'.thumb_img\').removeClass(\'thumb_img_active\');
			$(this).addClass(\'thumb_img_active\');
			$(\'.imagem_public\').hide();
			$(\'#imagem_public_\' + $(this).attr(\'rel\')).fadeIn();
		});

		$(\'#p_ano\').change(function(){
			$(\'#p_id\').val(null);
			submitForm();
		});

		$(\'#p_id\').change(function(){
			submitForm();
		});
	});

	function submitForm()
	{
		url = \'?page=mostras&p_cat=\' + $(\'#p_cat\').val() + \'&p_ano=\' + $(\'#p_ano\').val();
		if( $(\'#p_id\').val() != null ) {
			url += \'&p_id=\' + $(\'#p_id\').val();
		}
		document.location.href =  url;
	}
</script>
'; ?>

<input type="hidden" id="p_cat" value="<?php echo $this->_tpl_vars['parameters']['p_cat']; ?>
"/>
<table width="710" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="113" valign="top" bgcolor="#000000"><table width="113" align="center" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td><img src="templates/source/img/logo.jpg" width="113" height="233"></td>
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border"><table width="171" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Mostras <?php echo $this->_tpl_vars['parameters']['p_cat']; ?>
</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<select id="p_ano" class="form">
					<?php $_from = $this->_tpl_vars['anos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['item'] == $this->_tpl_vars['parameters']['p_ano']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<select id="p_id" class="form">
					<?php $_from = $this->_tpl_vars['publicacoes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
" <?php if ($this->_tpl_vars['item']['publicacao_id'] == $this->_tpl_vars['parameters']['p_id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['item']['titulo']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
          </tr>
		  <tr>
			  <td>&nbsp;</td>
		  </tr>

		  <tr><td>
			  <table width="120" cellspacing="0" cellpadding="0">
			  <?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_PUBLIC'): ?>
				  <tr>
					  <td class="fotinhosbox"><img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
"/></td>
				  </tr>
				<?php endif; ?>
			  <?php endforeach; endif; unset($_from); ?>
			  </table>
		  </td></tr>

          <tr>
            <td><div style="overflow-y:auto; height:160px; width:171px; margin-top: 20px;">
				<ul class="galeria">
					<?php $this->assign('key', 0); ?>
					<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<?php if ($this->_tpl_vars['item']['tag'] == 'CATALOGO'): ?>
							<?php $this->assign('key', ($this->_tpl_vars['key']+1)); ?>
							<li>
								<img src="?module=content&action=showImg&imagem_id=<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
&l=50&a=50" rel="<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
" class="thumb_img <?php if ($this->_tpl_vars['key'] == 1): ?>thumb_img_active<?php endif; ?>">
							</li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
            </div></td>
          </tr>
        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">
		<?php $this->assign('key', 0); ?>
		<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<?php if ($this->_tpl_vars['item']['tag'] == 'CATALOGO'): ?>
				<?php $this->assign('key', ($this->_tpl_vars['key']+1)); ?>
				<div class="imagem_public" id="imagem_public_<?php echo $this->_tpl_vars['item']['imagem_id']; ?>
" style="display: <?php if ($this->_tpl_vars['key'] == 1): ?>block<?php else: ?>none<?php endif; ?>;">
					<div>
						<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
"/>
					</div>
					<div style="margin-top: 20px;">
						<?php echo $this->_tpl_vars['item']['titulo']; ?>

					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>

		</td>
      </tr>

      <tr>
        <td colspan="3" align="right" bgcolor="#000000" class="line2">&nbsp;</td>
      </tr>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "content/includes/links_inferior_topo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <tr>
        <td colspan="3"><table width="670" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td><img src="templates/source/img/faixaprojetos.jpg" width="670" height="87"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="line">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "content/includes/destaques.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
          </tr>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "content/includes/publicacoes_midia.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </tbody></table></td>
      </tr>
      <tr>
        <td colspan="3" align="right">&nbsp;</td>
      </tr>
    </tbody></table>

<?php $this->_smarty_vars['capture']['content'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "content/template.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>