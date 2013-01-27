<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>Server Web FTP</h1></td>
  </tr>
</table>
{if $e_msg1}<div id="infobox"><strong>{$e_msg1}</strong><br />{$e_msg2}</div>{/if}
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><a href="serverftp.php?id={$srv.serverid}"><img src="templates/{$template}/images/home_24.png" alt="" align="absmiddle" /></a> {$bread_crumb}{if $file} > <a href="serverftp.php?id={$srv.serverid}&amp;path={$path}&amp;file={$file}">{$file}</a>{/if}</td>
    <td align="right"><input type="button" value="Server Details" onclick="window.location='serversummary.php?id={$srv.serverid}'" class="button blue" /></td>
  </tr>
</table>
<img src="templates/{$template}/images/spacer.gif" width="1" height="5" alt="" /><br />
{if !$file}
<table width="100%" cellpadding="2" cellspacing="1" class="data">
  <tr>
    <th>File</th>
    <th>Size</th>
    <th>User</th>
    <th>Group</th>
    <th>Perms</th>
    <th width="30"></th>
  </tr>
  {if !$srv.ipid}
  <tr onmouseover="this.className='mouseover'" onmouseout="this.className=''">
    <td colspan="5"><b>Server Not Installed Yet</b></td>
  </tr>
  {/if}
  {foreach from=$folders item=x}
  <tr onmouseover="this.className='mouseover'" onmouseout="this.className=''">
    <td style="text-align:left;"><img src="templates/{$template}/images/folder_24.png" align="absmiddle" alt="" /> <a href="serverftp.php?id={$srv.serverid}&path={$x.path}">{$x.name}</a></td>
    <td>{$x.size}</td>
    <td>{$x.owner}</td>
    <td>{$x.group}</td>
    <td>{$x.permsn}</td>
    <td><a href="#" onclick="doDeleteDir('{$x.name}', '{$srv.serverid}', '{$path}')"><img src="templates/{$template}/images/buttons/red.png" width="25" height="25" alt="Delete" title="Delete" /></a></td>
  </tr>
  {/foreach}
  {foreach from=$files item=x}
  <tr onmouseover="this.className='mouseover'" onmouseout="this.className=''">
    <td style="text-align:left;"><img src="templates/{$template}/images/preview_24.png" align="absmiddle" alt="" /> {$x.link}</td>
    <td>{$x.size}</td>
    <td>{$x.owner}</td>
    <td>{$x.group}</td>
    <td>{$x.permsn}</td>
    <td><a href="#" onclick="doDeleteFile('{$x.name}', '{$srv.serverid}', '{$path}')"><img src="templates/{$template}/images/buttons/red.png" width="25" height="25" alt="Delete" title="Delete" /></a></td>
  </tr>
  {/foreach}
</table>
{if $srv.ipid}
<img src="templates/{$template}/images/spacer.gif" width="1" height="10" alt="" /><br />
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><form method="post" action="serverftpprocess.php" enctype="multipart/form-data">
        <input type="hidden" name="task" value="fileupload" />
        <input type="hidden" name="id" value="{$srv.serverid}" />
        <input type="hidden" name="path" value="{$path_decoded}" />
        <input type="hidden" name="file" value="{$file}" />
        <table cellpadding="2" cellspacing="1" class="data">
          <tr>
            <th>File Upload (Max: {$max_filesize})</th>
          </tr>
          <tr>
            <td><input type="file" name="file" class="text" size="40" /></td>
          </tr>
          <tr>
            <td><input type="submit" value="Upload" class="button green" /></td>
          </tr>
        </table>
      </form></td>
    <td><form method="post" action="serverftpprocess.php">
        <input type="hidden" name="task" value="makedir" />
        <input type="hidden" name="id" value="{$srv.serverid}" />
        <input type="hidden" name="path" value="{$path_decoded}" />
        <table cellpadding="2" cellspacing="1" class="data">
          <tr>
            <th>Make New Directory</th>
          </tr>
          <tr>
            <td><input type="text" name="dir" class="text" size="40" /></td>
          </tr>
          <tr>
            <td align="center"><input type="submit" value="Create" class="button" /></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
{literal}
<script language="javascript" type="text/javascript">
<!--
function doDeleteFile(file, id, path) { if (confirm("Are you sure you want to delete file: "+file+"?")) { window.location='serverftpprocess.php?task=filedelete&id='+id+'&path='+path+'&file='+file; } }
function doDeleteDir(dir, id, path) { if (confirm("Are you sure you want to delete directory: "+dir+"?")) { window.location='serverftpprocess.php?task=dirdelete&id='+id+'&path='+path+'&dir='+dir; } }
-->
</script>
{/literal}
{/if}
{else}
<div align="center">
  <form method="post" action="serverftpprocess.php">
    <input type="hidden" name="task" value="filesave" />
    <input type="hidden" name="id" value="{$srv.serverid}" />
    <input type="hidden" name="path" value="{$path_decoded}" />
    <input type="hidden" name="file" value="{$file}" />
    <textarea name="filecontents" class="textarea" rows="30" cols="150">{$file_contents}</textarea>
    <br />
    <img src="templates/{$template}/images/spacer.gif" height="10" width="1" alt="" /><br />
    <input type="submit" value="Save" class="button green" />
  </form>
</div>
{/if}