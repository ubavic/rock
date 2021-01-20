		<footer>
			<div>
				<a href="/" title="Почетна страница">Почетна</a> • 
				<a href="/exam" title="Списак рокова">Рокови</a> • 
				<a href="/about" title="Више о сајту">О пројекту</a> 
<?php if(session()->get('logged')): ?>
				• <a href="/user/settings" title="Контролни панел">Контролни панел</a>
<?php endif; ?>
			</div>
<?php if(session()->get('logged')): ?>
			<div style="margin: 1em 0">
				Улоговани сте као <?= session()->get('name') ?> • <a href="/user/logout">Одјавите се</a>
			</div>
<?php endif; ?>
		</footer>
		<script src="/katex/katex.min.js"></script>
		<script src="/katex/auto-render.min.js"></script>
		<script src="/katex/copy-tex.min.js"></script>
		<script>window.onload = renderMathInElement(document.body);</script>
	</body>
</html>