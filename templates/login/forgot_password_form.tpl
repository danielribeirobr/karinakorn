{capture name="content"}
	<form method="post">
		<input type="hidden" name="module" id="module" value="login"/>
		<input type="hidden" name="action" id="action" value="loginForgotPasswordSendPassword"/>
		<fieldset>
			<legend>Forgot password</legend>

			<label for="email">Email:</label>
			<input type="text" name="email" id="email" value="{$form.email}"/>
			<br/>

			{if $error}
				<div class="error">{$error}</div>
			{/if}

			<input type="submit" value="send" class="submit"/>

		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}