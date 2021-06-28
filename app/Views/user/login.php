<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<form method="post" style="margin: 0 auto; max-width: 300px;">
		<h1>Пријавите се</h1>
		<div class="formRow">
			<label for="email" class="formRowElement"><em>E-mail</em>:</label>
			<input type="email" name="email" id="email" style="width: 100%;" value="" autofocus>
		</div>
		<div class="formRow">
			<label for="password" class="formRowElement">Шифра:</label>
			<div class="verticalRowSpacer"></div>
			<a href="/user/resetPassword">Заборавили сте шифру?</a>
			<input type="password" name="password" id="password" style="width: 100%;" value="">
		</div>
		<div class="formRow" style="align-items: flex-end;">
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Пријавите се</button>
		</div>
		<br>
	</form>
	<p style="text-align:center;">Немате налог? <a href="/user/register">Региструјте се</a></p>
<?= $this->endSection(); ?>