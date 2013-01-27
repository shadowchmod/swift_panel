<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>Login</h1></td>
  </tr>
</table>
{if $lockout}
<div align="center">
	<div align="center" style="width:400px;background-color:#FCF9D2;border:1px solid #F9D43E;padding:10px;"><strong>Too Many Incorrect Login Attempts</strong><br />
      Please wait 5 minutes before trying again.</div>
</div>
{elseif $task != 'password'}
<div align="center">
  {if $login_error}<div align="center" style="width:400px;background-color:#FCF9D2;border:1px solid #F9D43E;padding:10px;"><strong>Login Failed. Please Try Again.</strong><br />
      Your IP has been logged and admins notified of this failed attempt.</div><br />{/if}
  <form action="process.php" method="post">
    <input type="hidden" name="task" value="login" />
    <input type="hidden" name="return" value="{$return}" />
    <table border="0" cellpadding="0" cellspacing="10">
      <tr>
        <td align="right">Email:</td>
        <td><input type="text" name="email" class="text" size="30" value="{$email}" /></td>
      </tr>
      <tr>
        <td align="right">Password:</td>
        <td><input type="password" name="password" class="text" size="30" value="{$password}" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><label for="rememberme"><input type="checkbox" name="rememberme" id="rememberme"{if $remember_me} checked="checked"{/if} /> Remember my email</label></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="Login" class="button" /></td>
      </tr>
    </table>
  </form>
  <br />
  <a href="login.php?task=password">Forgot Password?</a>
</div>
{else}
<div align="center">
  {if $success == 'Yes'}<div align="center" style="width:400px;background-color:#FCF9D2;border:1px solid #F9D43E;padding:10px;"><strong>Password Sent.</strong><br />
      Your password has been reset and emailed to you.</div><br />
  {elseif $success == 'No'}<div align="center" style="width:400px;background-color:#FCF9D2;border:1px solid #F9D43E;padding:10px;"><strong>Email Not Found.</strong><br />
      Your IP has been logged and admins notified of this failed attempt.</div><br />
  {/if}
  <form action="process.php" method="post">
    <input type="hidden" name="task" value="password" />
    <table border="0" cellpadding="0" cellspacing="10">
      <tr>
        <td align="right">Email:</td>
        <td><input type="text" name="email" class="text" size="30" value="" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="Send Password" class="button" /></td>
      </tr>
    </table>
  </form>
  <br />
  <a href="login.php">Back to Login</a>
</div>
{/if}