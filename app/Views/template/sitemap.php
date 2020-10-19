<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?= base_url();?></loc> 
		<priority>1.0</priority>
		<changefreq>weekly</changefreq>
	</url>
	<url>
		<loc><?= base_url() . "/exam" ?></loc> 
		<priority>8.0</priority>
		<changefreq>weekly</changefreq>
	</url>
	<url>
		<loc><?= base_url() . "/about" ?></loc> 
		<priority>6.0</priority>
		<changefreq>monthly</changefreq>
	</url>
	<url>
		<loc><?= base_url() . "/user/login" ?></loc> 
		<priority>4.0</priority>
		<changefreq>yearly</changefreq>
	</url>
    <url>
        <loc><?= base_url() . "/user/register" ?></loc> 
        <priority>4.0</priority>
		<changefreq>yearly</changefreq>
    </url>
	<?php foreach($exams as $exam) : ?>
		<url>
			<loc><?= base_url() . '/exam/view/' . $exam->id ?></loc>
			<priority>0.5</priority>
			<changefreq>yearly</changefreq>
		</url>
	<?php endforeach; ?>
</urlset>
