<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
	<?php if($new): ?>
		<h1>Нови предмет</h1>
	<?php else: ?>
		<h1>Измени предмет <em><?= $subject->name ?></em></h1>
	<?php endif;?>
	<form style="margin: 1em 0;" method="post" id="form">
		<div class="formRow">
			<label for="name"  class="formRowElement" style="width: 4em;">Назив:</label>
            <input type="text" name="name" id="name" value="<?= $subject->name ?>" class="formRowElement">
		</div>
		<div class="formRow">
			<label for="code" class="formRowElement" style="width: 4em;">Код:</label>
			<input type="text" name="code" id="code" value="<?= $subject->code ?>"  class="formRowElement">
		</div>
		<div class="formRow no-print" style="align-items: flex-end;">
			<div style="margin-left:auto;"></div>
			<div onclick="confirmDelete()" class="button bigButton">Обриши рок</div>
			<button type="submit" class="button bigButton" onclick="window.onbeforeunload = null">Унеси</button>
		</div>
	</form>
	<script type="text/javascript">
		function confirmDelete() {
			if (confirm('Да ли сте сигурни да желите да обришете овај предмет? Ово ће неповратно обрисати све рокове за овај предмет.')) {
				window.location.href = '/subject/delete/<?= $subject->id ?>';
			}
		}
	</script>
<?= $this->endSection(); ?>