{include file="html_header.tpl"}

<div id="login_pane">

{if !$print_version}

<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
Logged in as: <b>{$username}</b> &nbsp;&nbsp;<input type="submit" value="Logout" name="logout" class="submit"></br>
<a href="my_account.php">Manage My Account</a>
</form>

{/if}

</div>