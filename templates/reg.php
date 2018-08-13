<?php
if ($_SESSION['docler']['logged_in'])
{
	header('location: ?q=greet');
	exit;
}

if (isset($_POST['register']))
{
	$register=$user->register($_POST);
}
?>

<h2>Register</h2>

<?php if(is_string($register)): ?>
<p style="color: red;"><?php print $register ?></p>
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
			<td><label for="password_agn">Password again:</label></td>
			<td><input type="password" name="password_agn" id="password_agn" required></td>
		</tr>
		<tr>
			<td><label for="name">Name:</label></td>
			<td><input type="text" name="name" id="name" required></td>
		</tr>
		<tr>
			<td colspan="2">
				<button name="register">Submit</button>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top: 10px;">
				<a href="?q=login">Back to login page</a>
			</td>
		</tr>
	</table>
</div>
</form>