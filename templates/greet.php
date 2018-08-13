<?php
if (!$_SESSION['docler']['logged_in'])
{
	header('location: ?q=login');
	exit;
}
else $user = new User($_SESSION['docler']['email']);

if (isset($_POST['logout']))
{
	$user->logout();
}
?>

<h2>Welcome <?php print $user->get_name() ?>!</h2>
<form method="post" action="">
	<button name="logout">Logout</button>
</form>