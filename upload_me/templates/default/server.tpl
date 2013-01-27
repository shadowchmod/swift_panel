<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>My Servers</h1></td>
  </tr>
</table>
{if $e_msg1}<div id="infobox"><strong>{$e_msg1}</strong><br />{$e_msg2}</div>{/if}
<table width="100%" cellpadding="1" cellspacing="1" class="data">
  <tr>
	<th width="26">#</th>
    <th width="50">Status</th>
    <th>Name &amp; Game</th>
    <th>Real Time Query (<a href="#" onclick="window.location.reload();">Refresh</a>)</th>
    <th width="60"></th>
  </tr>
  {foreach from=$servers item=srv}
  <tr onmouseover="this.className='mouseover'" class="{$srv.status}" onmouseout="this.className='{$srv.status}'">
    <td style="color:#666666;">{counter}</td>
    {if $srv.online == 'Pending'}{assign var='img' value='yellow'}
    {elseif $srv.online == 'Started'}{assign var='img' value='green'}
    {else}{assign var='img' value='red'}{/if}
  	<td><img src="templates/{$template}/images/buttons/{$img}.png" width="25" height="25" alt="{$srv.online}" title="{$srv.online}" /></td>
    <td><a href="serversummary.php?id={$srv.serverid}">{$srv.name}</a><br /><i>{$srv.game}</i></td>
    {if $srv.servername}
    <td style="line-height:13px;"><b>{$srv.servername}</b><br />{$srv.map} ( {$srv.players} )<br /><? } ?><i>{$srv.ip} <b>:</b> {$srv.port}</i></td>
    {elseif $srv.ip}
    <td><i>{$srv.ip} <b>:</b> {$srv.port}</i></td>
    {else}
    <td>Not Available</td>
    {/if}
    {if $srv.online == 'Stopped' && $srv.status != 'Suspended'}
    <td><a href="servermanage.php?task=start&amp;return=server.php&amp;serverid={$srv.serverid}"><img src="templates/{$template}/images/buttons/play.png" width="25" height="25" alt="Start" title="Start" /></a></td>
    {elseif $srv.online == 'Started' && $srv.status != 'Suspended'}
    <td><a href="servermanage.php?task=restart&amp;return=server.php&amp;serverid={$srv.serverid}"><img src="templates/{$template}/images/buttons/refresh.png" width="25" height="25" alt="Restart" title="Restart" /></a> <a href="servermanage.php?task=stop&amp;return=server.php&amp;serverid={$srv.serverid}"><img src="templates/{$template}/images/buttons/stop.png" width="25" height="25" alt="Stop" title="Stop" /></a></td>
    {else}
    <td></td>
    {/if}
  </tr>
  {foreachelse}
  <tr>
    <td colspan="8"><div id="infobox2"><strong>No Servers Found</strong><br />No servers found.</div></td>
  </tr>
  {/foreach}
</table>
<br />
<table align="center">
  <tr>
    <td width="12" align="right"><table style="width:12px;height:12px;" cellspacing="1" class="data">
        <tr class="Pending">
          <td></td>
        </tr>
      </table></td>
    <td>Pending</td>
    <td width="5"></td>
    <td width="12" align="right"><table style="width:12px;height:12px;" cellspacing="1" class="data">
        <tr class="Active">
          <td></td>
        </tr>
      </table></td>
    <td>Active</td>
    <td width="5"></td>
    <td width="12" align="right"><table style="width:12px;height:12px;" cellspacing="1" class="data">
        <tr class="Suspended">
          <td></td>
        </tr>
      </table></td>
    <td>Suspended</td>
  </tr>
</table>