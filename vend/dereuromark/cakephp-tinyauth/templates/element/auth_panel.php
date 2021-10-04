<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var bool|null $isPublic
 * @var array $user
 * @var array $roles
 * @var array $availableRoles
 * @var bool[] $access
 * @var string $path;
 */

use Cake\Error\Debugger;
use TinyAuth\Panel\AuthPanel;
use TinyAuth\Utility\Config;

if (!isset($params)) {
	$params = [];
}
if (!isset($path)) {
	$path = '';
}
if (!isset($isPublic)) {
	$isPublic = null;
}

?>

<section class="section-tile">
    <h1>TinyAuth</h1>

	<h2>Current URL</h2>
	<?php
	Debugger::dump($params);
	?>
	<br/>
	<p>TinyAuth URL path: <b style="font-weight: bold"><?php echo h($path); ?></b></p>

	<h2>Authentication (allow)</h2>
	<?php
	if (Config::get('allowAdapter')) {
		if ($isPublic === null) {
			echo '<div><small>No information available</small></div>';
		} else {
			$icon = $isPublic ? AuthPanel::ICON_PUBLIC : AuthPanel::ICON_RESTRICTED;
			echo '<p>' . $icon . ' <b style="font-weight: bold">' . ($isPublic ? 'public' : 'secured') . '</b> action</p>';
			if ($isPublic) {
				echo '<div><small>Any guest can visit this page</small></div>';
			} else {
				echo '<div><small>Login required to visit this page</small></div>';
			}
		}
	} else {
		echo '<i>disabled</i>';
	}
	?>

	<h2>Authorization (ACL)</h2>
	<?php
	if (Config::get('aclAdapter')) {
		if (!empty($user)) {

			echo '<p>Logged in with ID <b style="font-weight: bold">' . h($user['id']) . '</b></p>';

			echo 'Roles:<br/>';
			Debugger::dump($roles);

		} else {
			echo '<i>not logged in</i><br/>';
		}

	} else {
		echo '<i>disabled</i><br/>';
	}
	?>

	<br/>

	<?php if (!empty($access)) { ?>
	<p>
		<?php if (!$isPublic) { ?>
		The following roles have access to this action:
		<?php } else { ?>
		The following roles would have access to this action once you revoke public access:
		<?php } ?>
	</p>
	<ul>
		<?php
		foreach ($availableRoles as $role => $id) {
			echo '<li>';
			echo ($access[$role] ? '<b style="font-weight: bold; color: green">&#10003;</b>' : '<b style="font-weight: bold; color: red">&#128683;</b>') . ' ';
			echo h($role) . ' (id ' . $id . ')';
			echo '</li>';
		}
		?>
	</ul>
	<?php } ?>

</section>
