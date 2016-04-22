{capture name="content"}

	<h1>Listagem de usu&aacute;rios</h1>

	<input type="button" value="adicionar novo" onclick="document.location.href='?module=user_manager&action=user_managerAdd';"/>
	<form class="form" method="post">
		<fieldset>
			<legend>Buscar usu&aacute;rios</legend>

			<label for="name">Nome email ou login:</label>
			<input type="text" id="name" name="name" value="{$form.name}"/>
			<input type="submit" value="listar" class="button"/>
			[<a href="?module=user_manager&list_all=1">Listar todos</a>]

		</fieldset>
	</form>

	{if $form.name || $form.list_all}
		<table class="listing">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Login</th>
					<th>Email</th>
					<th>Senha</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$users item=item}
					<tr class="{cycle values="line1,line2"}">
						<td>{$item.name}</td>
						<td>{$item.login}</td>
						<td>{$item.email}</td>
						<td>{$item.password}</td>
						<td><a href="?module=user_manager&action=user_managerEdit&user_id={$item.user_id}">editar</a></td>
						<td><a href="?module=user_manager&action=user_managerDelete&user_id={$item.user_id}">excluir</a></td>
					</tr>
				{foreachelse}
					<tr class="not_found">
						<td colspan="10">Nenhum usu&aacute;rio encontrado</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}

{/capture}
{include file="includes/template.tpl"}