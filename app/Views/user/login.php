<main>
	<form method="post" style="margin: 0 auto; width: 300px;">
		<h2>Пријавите се</h2>
		<?php if (isset($validation)): ?>
			<div class="formRow" style="background-color:#A275D9; padding: 0.5em 0; border-radius: 3px">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<?php if (session()->get('success')): ?>
			<div class="formRow" style="background-color:#8CC476; padding: 0.5em 0; border-radius: 3px">
				<?= session()->get('success'); ?>
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
			<a href="/user/register">Регистујте се</a>
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Пријавите се</button>
		</div>
	</form>
</main>