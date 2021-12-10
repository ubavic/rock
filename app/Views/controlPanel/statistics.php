<?= $this->extend('controlPanel/layout'); ?>
<?= $this->section('cp_content'); ?>
	<div>
		<h2 style="margin-top:0">Статистика</h2>
        <svg id='heatmap' width='100%'></svg>
        <h3>.</h3>
        <svg id='bars' width='100%'></svg>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
    <script src="/js/statistics.js"></script>
<?= $this->endSection(); ?>
