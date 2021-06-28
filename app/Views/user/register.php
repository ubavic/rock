<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<form method="post" style="margin: 0 auto; max-width: 300px;">
		<h1>Региструјте се</h1>
		<p>Регистарција је дозвољена само студентима и наставницима Математичког факултета.</p>
		<div class="formRow">
			<label for="email" class="formRowElement"><em>E-mail</em>:</label>
			<input type="email" name="email" id="email" style="width: 100%;" autofocus>
			<span style="font-size: 0.9em; color: #333;">Мора бити факултетска адреса.</span>
		</div>
		<div class="formRow">
			<label for="password" class="formRowElement">Шифра:</label>
			<input type="password" name="password" id="password" style="width: 100%;">
			<span style="font-size: 0.9em; color: #333;">Мора да садржи најмање 8 карактера.</span>
		</div>
		<div class="formRow">
			<label for="pass_confirm" class="formRowElement">Потврдите шифру:</label>
			<input type="password" name="pass_confirm" id="pass_confirm" style="width: 100%;">
		</div>
		<p>Регистрацијом пристајете на <a href="/user/terms">услове регистрације</a>.</p>
		<div class="formRow" style="align-items: flex-end;">
			<div class="verticalRowSpacer"></div>
			<button type="submit" class="bigButton">Региструјте се</button>
		</div>
	</form>
	<p style="text-align:center;">Имате налог? <a href="/user/login">Пријавите се</a></p>
<?= $this->endSection(); ?>