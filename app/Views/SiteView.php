<?php

namespace Views;

class SiteView {
	public static function draw($content) {
		?>
		<!DOCYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Card Info</title>
			</head>
			<body>
				<div class="content">
					<?php global $auth; ?>
					<?php if($auth->isAuthorised()): ?>
					<form action="/auth/logout/" method="post">
						<button>Logout</button>
					</form>
					<?php else: ?>
					<form action="/auth/login/">
						<button>Logout</button>
					</form>
					<?php endif ?>
				</div>
				<div class="content">
					<?= $content ?>
				</div>
			</body>
		</html>
		<?php
	}
}