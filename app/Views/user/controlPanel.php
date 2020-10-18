<main>
	<h2>Кориснички контролни панел</h2>
	
	<div class="controlPanel">
		<nav>
			<a href="#" onclick="setControlPanel(0)" id="controlPanelMenuItem1">Профил</a>
			<a href="#" onclick="setControlPanel(1)" id="controlPanelMenuItem1">Креирани рокови</a>
			<a href="#" onclick="setControlPanel(2)" id="controlPanelMenuItem1">Сачувани рокови</a>
		</nav>
		<div id="controlPanelItem0" style="display:block">
			<h3 style="margin-top:0">Профил</h3>
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
			<form action="/user/controlpanel" method="post">
				<p>У наредној форми можете променити своје име. Ваше име, као и Ваш <i>e-mail</i>, је видљиво само другим члановима сајта. Пожељно је, али не и обавезно, да за име упишете Ваше лично име, на ћирилици.</p>
				<div class="formRow">
					<label for="name" style="width: 4em;">Име</label>
					<input name="name" id="name" style="width: 20em;" value="<?= $name ?>">
				</div>
				<div class="formRow">
					<span style="width: 4em;"><i>E-mail</i></span>
					<span style="width: 20em;"><?= $email ?></span>
				</div>
				<div class="formRow">
					<button class="smallButton" type="submit" value="changeName">Сачувај</button>
				</div>
			</form>
			<h4>Промени шифру</h4>
			<form action="/user/controlpanel" method="post">
				<div class="formRow">
					<label for="password" style="width: 8em;">Шифра</label>
					<input type="password" name="password" id="password" style="width: 20em;">
				</div>
				<div class="formRow">
					<span for="pass_confirm" style="width: 8em;">Понови шифру</span>
					<input type="password" name="pass_confirm" id="pass_confirm" style="width: 20em;">
				</div>
				<div class="formRow">
					<button class="smallButton" type="submit" value="changePassword">Сачувај</button>
				</div>
			</form>
		</div>
		<div id="controlPanelItem1">
			<h3 style="margin-top:0">Креирани рокови</h3>
			<div class="examList">
				<div class="examListHeader">
					<div class="examListType"><abbr title="Испит/колоквијум">Тип</abbr></div>
					<div class="examListSubject">Предмет</div>
					<div class="examListDate">Датум</div>
					<div style="margin-left:auto"></div>
					<div>Смер</div>
				</div>
				<?php if(empty($createdExams)): ?>
					<div style="text-align: center; padding: 1em; max-width: 600px; margin: 0 auto;">
						Нисте креирали ниједан рок. 
					</div>
				<?php else: ?>
					<?php foreach ($createdExams as $exam): ?>
						<a href="<?= '/exam/view/' . $exam->id ?>" class="examListRow" >
							<div class="examListType"><?= ($exam->type == 0) ? 'И' : 'К' ?></div>
							<div class="examListSubject"><?= $exam->subject_name ?></div>
							<div class="examListDate"><?= $exam->date ?></div>
							<div style="margin-left:auto"></div>
							<div><?= $exam->modules_string ?></div>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<div id="controlPanelItem2">
			<h3 style="margin-top:0">Сачувани рокови</h3>
			<div class="examList">
				<div class="examListHeader">
					<div class="examListType"><abbr title="Испит/колоквијум">Тип</abbr></div>
					<div class="examListSubject">Предмет</div>
					<div class="examListDate">Датум</div>
					<div style="margin-left:auto"></div>
					<div>Смер</div>
				</div>
				<?php if(empty($savedExams)): ?>
					<div style="text-align: center; padding: 1em; max-width: 600px; margin: 0 auto;">
						Нисте сачували ниједан рок. 
					</div>
				<?php else: ?>
					<?php foreach ($savedExams as $exam): ?>
						<a href="<?= '/exam/view/' . $exam->id ?>" class="examListRow" >
							<div class="examListType"><?= ($exam->type == 0) ? 'И' : 'К' ?></div>
							<div class="examListSubject"><?= $exam->subject ?></div>
							<div class="examListDate"><?= $exam->date ?></div>
							<div style="margin-left:auto"></div>
							<div><?= $exam->modules ?></div>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</main>