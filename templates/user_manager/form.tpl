{capture name="content"}
	<h1>Usu&aacute;rio</h1>

	<form method="post" class="form">
		<input type="hidden" name="module" id="module" value="user_manager"/>
		<input type="hidden" name="action" id="action" value="user_managerSave"/>
		<input type="hidden" name="user_id" id="user_id" value="{$form.user_id}"/>
		<fieldset>
			<legend>Detalhes do usu&aacute;rio</legend>

			<label for="plan">Nome:</label>
			<input type="text" name="name" id="name" value="{$form.name}"/>
			{if $error.name}
				<div class="error">{$error.name}</div>
			{/if}
			<br/>

			<label for="login">Login:</label>
			<input type="text" name="login" id="login" value="{$form.login}"/>
			{if $error.login}
				<div class="error">{$error.login}</div>
			{/if}
			<br/>

			<label for="email">Email:</label>
			<input type="text" name="email" id="email" value="{$form.email}"/>
			{if $error.email}
				<div class="error">{$error.email}</div>
			{/if}
			<br/>

			<label for="password">Senha:</label>
			<input type="password" name="password" id="password" value=""/>
			{if $form.user_id}
				<div class="info">Digite a senha somente se voc&ecirc; for modific&aacute;-la</div>
			{/if}
			{if $error.password}
				<div class="error">{$error.password}</div>
			{/if}
			<br/>

			<label for="status">Ativo:</label>
			<input type="checkbox" class="checkbox" name="status" id="status" value="1" {if $form.status} checked {/if}/>
			<br/>

			<input type="submit" value="Salvar" class="submit"/>
			<input type="button" value="Cancelar" class="submit2" onclick="history.back();"/>
		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}