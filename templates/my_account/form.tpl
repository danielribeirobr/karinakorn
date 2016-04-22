{capture name="content"}
	<h1>My account</h1>

	{if $info}
		<div class="message">{$info}</div>
	{/if}

	<form method="post" class="form">
		<input type="hidden" name="module" id="module" value="my_account"/>
		<input type="hidden" name="action" id="action" value="my_accountSave"/>
		<fieldset>
			<legend>My account details</legend>

			<label for="plan">Name:</label>
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

			<label for="password">Password:</label>
			<input type="password" name="password" id="password" value=""/>
			{if $form.user_id}
				<div class="info">Type the password only if you want to change it</div>
			{/if}
			{if $error.password}
				<div class="error">{$error.password}</div>
			{/if}
			<br/>

			<label for="password">Receive email in:</label>
			<select name="email_type" id="email_type">
				<option value="">--Select--</option>
				<option value="plain" {if $form.email_type == 'plain'} selected {/if}>text/plain</option>
				<option value="html" {if $form.email_type == 'html'} selected {/if}>html</option>
			</select>
			{if $error.email_type}
				<div class="error">{$error.email_type}</div>
			{/if}
			<br/>


			<label for="website">Website:</label>
			<input type="text" name="website" id="website" value="{$form.website}"/>
			{if $error.website}
				<div class="error">{$error.website}</div>
			{/if}
			<br/>

			<label for="website">Logo url:</label>
			<input type="text" name="logo_url" id="logo_url" value="{$form.logo_url}"/>
			{if $error.logo_url}
				<div class="error">{$error.logo_url}</div>
			{/if}
			<br/>

			<input type="submit" value="submit" class="submit"/>
		</fieldset>
	</form>

{/capture}
{include file="includes/template_admin.tpl"}