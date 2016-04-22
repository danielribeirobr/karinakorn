<?php /* Smarty version 2.6.14, created on 2011-05-27 14:48:30
         compiled from /home/daniel/projetos/karinakorn/templates/content/videos.tpl */ ?>
<?php ob_start(); ?>
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
            <td>Videos</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="Titulo">
				<?php echo $this->_tpl_vars['publicacao']['titulo']; ?>

            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
		  <tr class="Textomain">
            <td><?php echo $this->_tpl_vars['publicacao']['descricao']; ?>
</td>
          </tr>

        </tbody></table></td>
        <td width="406" align="center" bgcolor="#000000">
			<?php echo $this->_tpl_vars['publicacao']['CAMPOS']['VIDEO']; ?>

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
        <td colspan="3">


		<table cellspacing="0" cellpadding="0" align="center" width="670">
          <tbody><tr>
            <td height="87" colspan="3"><img height="87" width="670" src="templates/source/img/faixavideos.jpg"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td class="line" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#cc0000" class="Titulo_pto" colspan="3">Galeria de Vídeos </td>
          </tr>


		  <?php $_from = $this->_tpl_vars['publicacoes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td class="Titulo_pto">&nbsp;</td>
				<td bgcolor="#000000" width="191" class="border">&nbsp;</td>
				<td class="Titulo_pto">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="93">&nbsp;</td>
				<td bgcolor="#000000" class="border"><table cellspacing="0" cellpadding="0" align="center" width="171">
				  <tbody><tr>
					<td class="Textomain"><?php echo $this->_tpl_vars['item']['titulo']; ?>
</td>
				  </tr>
				</tbody></table></td>
				<td align="center" width="386">
					<?php $_from = $this->_tpl_vars['item']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item_img']):
?>
						<?php if ($this->_tpl_vars['item_img']['tag'] == 'IMAGEM_VIDEO'): ?>
						<a href="?page=videos&p_id=<?php echo $this->_tpl_vars['item']['publicacao_id']; ?>
"><img src="db_imagens/<?php echo $this->_tpl_vars['item_img']['arquivo']; ?>
" border="0"/></a>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</td>
			  </tr>
	      <?php endforeach; endif; unset($_from); ?>
        </tbody></table>

		</td>
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