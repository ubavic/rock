<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<form method="post" style="margin: 0 auto; width: 300px;">
		<h1>Пријавите се</h1>
		<?php if (isset($validation)): ?>
			<div class="formRow error">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<div class="formRow">
			<label for="email" class="formRowElement"><em>E-mail</em>:</label>
			<input name="email" id="email" style="width: 300px;" value="<?= set_value('email') ?>">
		</div>
		<div class="formRow">
			<label for="password" class="formRowElement">Шифра:</label>
			<input type="password" name="password" id="password" style="width: 300px;" value="">
		</div>
		<div class="formRow" style="align-items: flex-end;">
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Пријавите се</button>
		</div>
		<br>
		<div style="padding: 0.5em;">
			<a href="/user/register">Региструјте се</a>
		</div>
		<div style="padding: 0.5em;">
			<a href="/user/resetPassword">Заборавили сте шифру?</a>
		</div>
	</form>
<?= $this->endSection(); ?>