<?php
 
namespace Views;

use Models\User;

class UserView {
	public static function draw(User $user) {
		?>
		<div class="user">
			<header>
				<h3><?= $user->name ?></h3>
			</header>
			<section>
				<p>Email: <strong><?= $user->email ?></strong></p>
				<hr>
				<ul>
				<?php foreach ($user->card as $card): ?>
					<li><?= $card->name ?></li>
				<?php endforeach; ?>
				</ul>
			</section>
		</div>
		<?php
	}
}