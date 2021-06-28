<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<form method="post" style="margin: 0 auto; max-width: 300px;">
		<h1>Повратак шифре</h1>
		<p>Ако сте заборавили шифру унесете мејл адресу с којом сте се регистровали, а затим пратите упутсва која ће вам бити послата на мејл.</p>
		<div class="formRow">
			<label for="email" class="formRowElement" autofocus><em>E-mail</em>:</label>
			<input type="email" name="email" id="email" style="width: 100%;" autofocus>
		</div>
		<div class="formRow" style="align-items: flex-end;">
			<div style="margin-left: auto"></div>
			<button type="submit" class="bigButton">Пошаљи захтев</button>
		</div>
	</form>
	<p style="text-align:center;">Ипак знате шифру? <a href="/user/login">Пријавите се</a></p>
<?= $this->endSection(); ?>