<?php /* Smarty version 2.6.14, created on 2011-05-18 10:43:56
         compiled from /home/daniel/projetos/karinakorn/templates/content/midia.tpl */ ?>
<?php ob_start();  echo '
<script type="text/javascript">
	$(function(){
		$(\'.thumb_img\').click(function() {
			$(\'.thumb_img\').removeClass(\'thumb_img_active\');
			$(this).addClass(\'thumb_img_active\');
			$(\'.imagem_public\').hide();
			$(\'#imagem_public_\' + $(this).attr(\'rel\')).fadeIn();
		});

		$(\'#p_mes\').change(function(){
			$(\'#p_id\').val(null);
			submitForm();
		});

		$(\'#p_id\').change(function(){
			submitForm();
		});
	});

	function submitForm()
	{
		url = \'?page=midia&p_cat=\' + $(\'#p_cat\').val() + \'&p_ano=\' + $(\'#p_ano\').val() + \'&p_mes=\' + $(\'#p_mes\').val();
		if( $(\'#p_id\').val() ) {
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
          <tr>
            <td>
			  <?php $_from = $this->_tpl_vars['categorias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				  <li class="li"><a href="?page=midia&p_cat=<?php echo $this->_tpl_vars['item']; ?>
" class="linkmenu<?php if ($this->_tpl_vars['parameters']['p_cat'] != $this->_tpl_vars['item']): ?>1<?php else: ?>2<?php endif; ?>" title="Projetos Karina Korn - <?php echo $this->_tpl_vars['item']; ?>
" alt="Projetos <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>
			  <?php endforeach; endif; unset($_from); ?>
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border"><table width="171" align="center" cellpadding="0" cellspacing="0">

          <tbody><tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Mídia <?php echo $this->_tpl_vars['parameters']['p_cat']; ?>
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
				<select id="p_mes" class="form">
					<?php $_from = $this->_tpl_vars['meses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']; ?>
" <?php if ($this->_tpl_vars['item'] == $this->_tpl_vars['parameters']['p_mes']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
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
          <tr>
            <td>
				<table width="80" cellpadding="0" cellspacing="0">
					<tr>
						<td class="fotinhosbox">
							<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
								<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_DESTAQUE'): ?>
									<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
"/>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						</td>
					</tr>
				</table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">			
			<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'PDF'): ?>
				<a href="?module=content&action=downloadAnexo&anexo_id=<?php echo $this->_tpl_vars['publicacao']['ANEXOS']['0']['anexo_id']; ?>
"><img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
" border="0"/></a>
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
            <td><img src="templates/source/img/faixamidia.jpg" width="670" height="87"></td>
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