<?= $this->extend('controlPanel/layout'); ?>
<?= $this->section('cp_content'); ?>
<div>
	<h2 style="margin-top:0">Подешавања</h2>
	<?php if (isset($validation)): ?>
		<div class="formRow error">
			<?= $validation->listErrors() ?>
		</div>
	<?php endif; ?>
	<form action="/cp/settings" method="post">
		<h3>Лични подаци</h3>
		<p>У наредној форми можете променити своје име. Ваше име, као и Ваш <i>e-mail</i>, је видљиво само другим члановима сајта. Пожељно је, али не и обавезно, да за име упишете Ваше лично име, на ћирилици.</p>
		<div class="formRow">
			<label for="name" style="width: 4em;">Име</label>
			<input name="name" id="name" style="width: 20em;" value="<?= $user->name ?>">
		</div>
		<div class="formRow">
			<span style="width: 4em;"><i>E-mail</i></span>
			<span style="width: 20em;"><?= $user->email ?></span>
		</div>
		<div class="formRow">
			<div class="verticalRowSpacer"></div>
			<button class="button bigButton" type="submit" value="changeName">Сачувај</button>
		</div>
	</form>
	<form action="/cp/settings" method="post">
	<h3>Промени шифру</h3>
		<div class="formRow">
			<label for="password" style="width: 8em;">Шифра</label>
			<input type="password" name="password" id="password" style="width: 20em;">
		</div>
		<div class="formRow">
			<span for="pass_confirm" style="width: 8em;">Понови шифру</span>
			<input type="password" name="pass_confirm" id="pass_confirm" style="width: 20em;">
		</div>
		<div class="formRow">
			<div class="verticalRowSpacer"></div>
			<button class="button bigButton" type="submit" value="changePassword">Сачувај</button>
		</div>
	</form>
</div>
<?= $this->endSection(); ?>