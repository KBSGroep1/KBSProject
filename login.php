<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="UTF-8" />

		<style>

			*, *:before, *:after {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: Arial; /* todo */
				padding: 64px;
			}

			h1 {
				margin-bottom: 8px;
			}

			input {
				padding: 4px;
				margin-bottom: 8px;
			}

		</style>
	</head>
	<body>
		<h1>Log in to CMS</h1>
		<form method="POST">
			<label for="username">
				Username: <br />
				<input type="text" id="username" name="username" autofocus required />
			</label>
			<br />
			<label for="password">
				Password: <br />
				<input type="text" id="password" name="password" autofocus required />
			</label>
			<br />
			<input type="submit" value="Login" />
		</form>
		<br />
		Forgotten your password? Sucks to be you.
	</body>
</html>
