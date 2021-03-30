<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<h1>Повратак шифре</h1>
	<form method="post">
		<p>Ако сте заборавили шифру, можете затржити нову шифру. Потребно је да унесете мејл адресу с којом сте се регистровали, а затим да пратите упутсва која ће вам бити послата на мејл.</p>
		<div class="formRow">
			<label for="email" class="formRowElement"><em>E-mail</em>:</label>
			<input name="email" id="email" style="width: 300px;">
		</div>
		<?php if(isset($validation)): ?>
			<div class="formRow error">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<div class="formRow" style="align-items: flex-end;">
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Пошаљи захтев</button>
		</div>
	</form>
<?= $this->endSection(); ?>