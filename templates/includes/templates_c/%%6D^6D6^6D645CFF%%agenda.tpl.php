<?php /* Smarty version 2.6.14, created on 2012-12-16 13:05:53
         compiled from /home/daniel_com/danielribeiro.com/karinanork/templates/content/agenda.tpl */ ?>
<?php ob_start(); ?>
<table width="710" cellspacing="0" cellpadding="0">
      <tbody><tr>
        <td width="113" valign="top" bgcolor="#000000"><table width="113" align="center" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td><img src="templates/source/img/logo.jpg" width="113" height="233"></td>
          </tr>
        </tbody></table></td>
        <td width="191" height="368" bgcolor="#000000" class="border">
			<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
				<?php if ($this->_tpl_vars['item']['tag'] == 'IMG_DESTAQUE'): ?>
					<img src="db_imagens/<?php echo $this->_tpl_vars['item']['arquivo']; ?>
"/>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</td>
        <td width="406" align="center" bgcolor="#000000">
			<div style="overflow-y:auto; height:330px; width:400px; margin: 5px; margin-top: 20px; text-align: left;">
				<div><?php echo $this->_tpl_vars['publicacao']['CAMPOS']['DATA_LOCAL']; ?>
</div>
				<div><?php echo $this->_tpl_vars['publicacao']['descricao']; ?>
</div>
			</div>
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
            <td height="87" width="600" colspan="2"><img height="87" width="670" src="templates/source/img/faixaagenda.jpg"></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td class="line" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FF6600" class="Titulo_pto" colspan="2">Agenda de Eventos de Arquitetura e Decoração</td>
          </tr>
          <tr>
            <td width="190">&nbsp;</td>
            <td width="480">&nbsp;</td>
          </tr>

		  <?php $_from = $this->_tpl_vars['publicacoes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td align="center">
					<?php $_from = $this->_tpl_vars['publicacao']['IMAGENS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item_img']):
?>
						<?php if ($this->_tpl_vars['item_img']['tag'] == 'IMG_PEQUENA'): ?>
							<img src="db_imagens/<?php echo $this->_tpl_vars['item_img']['arquivo']; ?>
"/>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</td>
				<td class="Td_dicas" rowspan="2"><a class="linkdicas" href="dicasdecoracao.html"><?php echo $this->_tpl_vars['item']['CAMPOS']['DATA_LOCAL']; ?>
</a></td>
			  </tr>
			  <tr>
				<td bgcolor="#000000" align="center"><?php echo $this->_tpl_vars['item']['titulo']; ?>
</td>
				</tr>
			  <tr>
				<td align="center">&nbsp;</td>
				<td>&nbsp;</td>
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