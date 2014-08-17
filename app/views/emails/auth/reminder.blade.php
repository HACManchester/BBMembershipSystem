<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Reset your password</h2>

		<div>
			To reset your password please visit this url:<br />
            {{ URL::to('password/reset', array($token)) }}.<br/>
			This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
		</div>
	</body>
</html>
