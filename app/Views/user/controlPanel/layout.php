<main>
	<h1>Кориснички контролни панел</h1>
	<div class="controlPanel">
        <nav>
        	<a href="/user/settings">Подешавања</a>
        	<a href="/user/exams">Креирани рокови</a>
        	<a href="/user/saved">Сачувани рокови</a>
            <?php if (session()->get('can_manage_users')): ?>
                <div>Aдминистрација</div>
                <a href="/user/all">Корисници</a>
                <a href="/user/log">Лог</a>
            <?php endif; ?>
        	<div>Остало</div>
            <a href="/tools">Алати</a>
        	<a href="/manual">Упутство</a>
        </nav>
        <?= $this->renderSection('content'); ?>
    </div>
</main>