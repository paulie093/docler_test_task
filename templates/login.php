<?php
if ($_SESSION['docler']['logged_in'])
{
	header('location: ?q=greet');
	exit;
}

if (isset($_POST['login']))
{
	$user = new User();
	$exists=$user->login_check($_POST);
}
?>

<h2>Login</h2>

<?php if(is_string($exists)): ?>
<p style="color: red;"><?php print $exists ?></p>
<?php endif; ?>

<?php if($_GET['confirm']=='success'): ?>
<p style="color: green;">Account is activated successfully</p>
<?php elseif($_GET['confirm']=='failed'): ?>
<p style="color: red;">Account is already activated or does not exist in the database anymore</p>
<?php endif; ?>

<form method="post" action="">
	<table>
		<tr>
			<td><label for="email">E-mail:</label></td>
			<td><input type="email" name="email" id="email" required></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label></td>
			<td><input type="password" name="password" id="password" required></td>
		</tr>
		<tr>
			<td colspan="2">
				<button name="login">Login</button>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 10px;">
				<a href="?q=reg">Register</a>
			</td>
		</tr>
	</table>
</div>
</form>