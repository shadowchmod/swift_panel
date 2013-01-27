<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>Server Details</h1></td>
  </tr>
</table>
{if $e_msg1}<div id="infobox"><strong>{$e_msg1}</strong><br />{$e_msg2}</div>{/if}
{if $srv.status == 'Active'}
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">{if $srv.online == 'Stopped'}
      <input type="button" value="Start Server" onclick="window.location='servermanage.php?task=start&amp;serverid={$srv.serverid}'" class="button green start" />
      {elseif $srv.online == 'Started'}
	  <input type="button" value="Restart Server" onclick="window.location='servermanage.php?task=restart&amp;serverid={$srv.serverid}'" class="button blue restart" />
	  <input type="button" value="Stop Server" onclick="window.location='servermanage.php?task=stop&amp;serverid={$srv.serverid}'" class="button red stop" />
      {/if}</td>
    {if $srv.webftp}
    <td align="right"><input type="button" value="Web FTP" onclick="window.location='serverftp.php?id={$srv.serverid}'" class="button blue" /></td>
    {/if}
  </tr>
</table>
{/if}
<img src="templates/{$template}/images/spacer.gif" width="1" height="6" alt="" /><br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" valign="top"><fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader">Server Information</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;">Name</td>
          <td class="fieldarea">{$srv.name}</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Game</td>
          <td class="fieldarea">{$srv.game}</td>
        </tr>
        {if $srv.boxlocation}
        <tr>
          <td class="fieldname" style="height:20px;">Location</td>
          <td class="fieldarea">{$srv.boxlocation}</td>
        </tr>
        {/if}
        {if $srv.status == 'Pending'}{assign var='color' value='#FFAA00'}
    	{elseif $srv.status == 'Active'}{assign var='color' value='#669933'}
    	{else}{assign var='color' value='#DD0000'}{/if}
        <tr>
          <td class="fieldname" style="height:20px;">Status</td>
          <td class="fieldarea"><font color="{$color}"><b>{$srv.status}</b></font></td>
        </tr>
      </table>
      </fieldset>
      <form method="post" action="serverprocess.php">
      <input type="hidden" name="task" value="serveredit" />
      <input type="hidden" name="serverid" value="{$srv.serverid}" />
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader">Server Configuration</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;">Max Slots</td>
          <td class="fieldarea">{$srv.slots}</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Type</td>
          <td class="fieldarea">{$srv.type}</td>
        </tr>
        {if $srv.cfg1name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg1name}</td>
          {if $srv.cfg1edit}<td class="fieldarea"><input type="text" name="cfg1" class="text" size="15" value="{$srv.cfg1}" /></td>
          {else}<td class="fieldarea">{$srv.cfg1}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg2name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg2name}</td>
          {if $srv.cfg2edit}<td class="fieldarea"><input type="text" name="cfg2" class="text" size="15" value="{$srv.cfg2}" /></td>
          {else}<td class="fieldarea">{$srv.cfg2}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg3name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg3name}</td>
          {if $srv.cfg3edit}<td class="fieldarea"><input type="text" name="cfg3" class="text" size="15" value="{$srv.cfg3}" /></td>
          {else}<td class="fieldarea">{$srv.cfg3}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg4name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg4name}</td>
          {if $srv.cfg4edit}<td class="fieldarea"><input type="text" name="cfg4" class="text" size="15" value="{$srv.cfg4}" /></td>
          {else}<td class="fieldarea">{$srv.cfg4}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg5name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg5name}</td>
          {if $srv.cfg5edit}<td class="fieldarea"><input type="text" name="cfg5" class="text" size="15" value="{$srv.cfg5}" /></td>
          {else}<td class="fieldarea">{$srv.cfg5}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg6name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg6name}</td>
          {if $srv.cfg6edit}<td class="fieldarea"><input type="text" name="cfg6" class="text" size="15" value="{$srv.cfg6}" /></td>
          {else}<td class="fieldarea">{$srv.cfg6}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg7name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg7name}</td>
          {if $srv.cfg7edit}<td class="fieldarea"><input type="text" name="cfg7" class="text" size="15" value="{$srv.cfg7}" /></td>
          {else}<td class="fieldarea">{$srv.cfg7}</td>{/if}
        </tr>
        {/if}
        {if $srv.cfg8name}
        <tr>
          <td class="fieldname" style="height:20px;">{$srv.cfg8name}</td>
          {if $srv.cfg8edit}<td class="fieldarea"><input type="text" name="cfg8" class="text" size="15" value="{$srv.cfg8}" /></td>
          {else}<td class="fieldarea">{$srv.cfg8}</td>{/if}
        </tr>
        {/if}
      </table>
      </fieldset>
      {if $srv.cfg1edit || $srv.cfg2edit || $srv.cfg3edit || $srv.cfg4edit || $srv.cfg5edit || $srv.cfg6edit || $srv.cfg7edit || $srv.cfg8edit}
      <img src="templates/{$template}/images/spacer.gif" height="6" width="1" alt="" /><br />
      <div align="center">
        <input type="submit" value="Save Changes" class="button green" />
        <input type="reset" value="Cancel Changes" class="button red" />
      </div>{/if}</form></td>
    <td width="50%" valign="top">
    {if $srv.showftp && $srv.ip}
    <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader">FTP Details</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;">IP Address</td>
          <td class="fieldarea">{$srv.ip}</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Port</td>
          <td class="fieldarea">{$srv.ftpport}</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">User</td>
          <td class="fieldarea">{$srv.user}</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Password</td>
          <td class="fieldarea">{$srv.password}</td>
        </tr>
      </table>
      </fieldset>
      {/if}
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader">Server Status</td>
        </tr>
        {if $srv.online == 'Pending'}{assign var='color' value='#FFAA00'}
    	{elseif $srv.online == 'Started'}{assign var='color' value='#669933'}
    	{else}{assign var='color' value='#DD0000'}{/if}
        <tr>
          <td class="fieldname" style="height:20px;width:110px;">Status</td>
          <td class="fieldarea"><font color="{$color}"><b>{$srv.online}</b></font> (<a href="#" onclick="window.location.reload();">Refresh</a>)</td>
        </tr>
        {foreach from=$query key=name item=value}
        <tr>
          <td class="fieldname" style="height:20px;">{$name}</td>
          <td class="fieldarea">{$value}</td>
        </tr>
        {/foreach}
      </table>
      </fieldset></td>
  </tr>
</table>