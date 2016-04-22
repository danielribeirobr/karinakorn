{capture name="content"}
	<form method="post">
		<input type="hidden" name="module" id="module" value="login"/>
		<input type="hidden" name="action" id="action" value="loginDoLogin"/>
		<input type="hidden" name="redirect" id="redirect" value="{$redirect}"/>
		<fieldset>
			<legend>Login</legend>

			<label for="login">Usu&aacute;rio:</label>
			<input type="text" name="login" id="login" value="{$login}"/>
			<br/>

			<label for="password">Senha:</label>
			<input type="password" name="password" id="password" value="{$password}"/>
			<br class="clear"/>

			{if $error}
				<div class="error">{$error}</div>
			{/if}

			<input type="submit" value="login" class="submit"/>

			<!--
			<br/>
			Forgot your password? Click <a href="?module=login&action=loginForgotPasswordForm">here</a>!
			-->

		</fieldset>
	</form>
{/capture}
{include file="includes/template.tpl"}