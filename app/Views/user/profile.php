<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1><?= $user->name ?></h1>
	<p><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></p>
    <p>Корисник је регистрован: <?= date_format(date_create($user->created_at), 'd.m.Y.') ?></p>
	<p>Корисник је креирао: <a href="/user/<?= $user->id ?>/exams"> <?= $count ?> рок/рокова </a></p>
	<?php if ($user->id == session()->get('id')): ?>
		<div class="formRow">
			<div class="verticalRowSpacer"></div>
			<a href="/user/settings" class="button bigButton">Измени профил</a>
		</div>
	<?php endif; ?>
	<?php if (session()->get('can_manage_users')): ?>
		<form action="/user/<?= $user->id ?>" method="post">
			<h2>Дозволе корисника</h2>
			<div class="formRow">
				<label for="can_add" style="width: 10em;">Додавање рокова:</label>
				<select name="can_add" id="can_add" style="width: 15em;">
  					<option value="0" <?= ($user->can_add == 0) ? 'selected' : '' ?>>Није дозвољено</option>
  					<option value="1" <?= ($user->can_add == 1) ? 'selected' : '' ?>>Дозвољено</option>
				</select>
			</div>
			<div class="formRow">
				<label for="can_edit" style="width: 10em;">Измена рокова:</label>
				<select name="can_edit" id="can_edit" style="width: 15em;">
  					<option value="0" <?= ($user->can_edit == 0) ? 'selected' : '' ?>>Није дозвољено</option>
  					<option value="1" <?= ($user->can_edit == 1) ? 'selected' : '' ?>>Само сопствених</option>
					<option value="2" <?= ($user->can_edit == 2) ? 'selected' : '' ?>>Дозвољено</option>
				</select>
			</div>
			<div class="formRow">
				<label for="can_delete" style="width: 10em;">Брисање рокова:</label>
				<select name="can_delete" id="can_delete" style="width: 15em;">
  					<option value="0" <?= ($user->can_delete == 0) ? 'selected' : '' ?>>Није дозвољено</option>
  					<option value="1" <?= ($user->can_delete == 1) ? 'selected' : '' ?>>Дозвољено</option>
				</select>
			</div>
			<div class="formRow">
				<label for="can_manage_users" style="width: 13.35em;">Управљање корисницима:</label>
				<select name="can_manage_users" id="can_manage_users" style="width: 11em;">
  					<option value="0" <?= ($user->can_manage_users == 0) ? 'selected' : '' ?>>Није дозвољено</option>
  					<option value="1" <?= ($user->can_manage_users == 1) ? 'selected' : '' ?>>Дозвољено</option>
				</select>
			</div>
			<div class="formRow">
				<div class="verticalRowSpacer"></div>
				<button class="button bigButton" type="submit" value="changeName">Сачувај</button>
			</div>
		</form>
	<?php endif; ?>
<?= $this->endSection(); ?>