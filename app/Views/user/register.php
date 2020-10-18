<main>
	<form method="post" style="margin: 0 auto; width: 300px;">
		<h2>Регистујте се</h2>
		<?php if(isset($validation)): ?>
			<div class="formRow">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<div class="formRow">
			<label for="email" class="formRowElement"><em>E-mail</em>:</label>
			<input name="email" id="email" style="width: 300px;">
		</div>
		<div class="formRow">
			<label for="password" class="formRowElement">Шифра:</label>
			<input type="password" name="password" id="password" style="width: 300px;">
		</div>
		<div class="formRow">
			<label for="pass_confirm" class="formRowElement">Потврдите шифру:</label>
			<input type="password" name="pass_confirm" id="pass_confirm" style="width: 300px;">
		</div>
		<p>Регистрацијом на овом сајту пристајете на <a href="/user/terms">услове регистрације</a>.</p>
		<div class="formRow" style="align-items: flex-end;">
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Регистујте се</button>
		</div>
	</form>
</main>