<?php

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use oddEvan\Periodical\Rating;
use Symfony\Component\Yaml\Yaml;

require_once(__DIR__ . '/vendor/autoload.php');

$mdenv = new Environment();
$mdenv->addExtension(new CommonMarkCoreExtension());
$mdenv->addExtension(new FrontMatterExtension());

$md = new MarkdownConverter($mdenv);

$issue = Yaml::parseFile(__DIR__ . '/issue.yml');

$issue['storyData'] = [];
$issueHtml = [];
foreach ($issue['stories'] as $filename) {
	$contents = file_get_contents(__DIR__ . '/' . $filename);
	$result = $md->convert($contents);

	$issue['storyData'][] = $result->getFrontMatter();
	$issueHtml[] = $result->getContent();
}

?>
<!DOCTYPE html>
<head>
	<title>Periodical</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fanwood+Text:ital@0;1&family=Raleway:wght@300&display=swap">
	<link rel="stylesheet" href="layout.css">
	<script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>
	<link rel="stylesheet" href="paged.css">
</head>
<body>
<!--
<?php print_r($issue); ?>
-->

<section
	class="cover nobreak<?= empty($issue['cover']['invert']) ? '' : ' invert' ?>"
	style="background-image: url(<?= $issue['cover']['src'] ?>)"
>
	<h1>
		<svg aria-label="Periodical" width="118.13mm" height="18.796mm" version="1.1" viewBox="0 0 118.13 18.796" xmlns="http://www.w3.org/2000/svg">
			<g transform="translate(-21.624 -14.766)">
				<g transform="matrix(.26458 0 0 .26458 10.687 -.44528)" fill="currentcolor" style="white-space:pre">
					<path d="m41.338 127.57v-68.16h28.608q4.608 0 8.448 1.92t6.72 5.088 4.416 7.104 1.536 8.064q0 5.664-2.592 10.848-2.496 5.088-7.2 8.256-4.608 3.168-10.752 3.168h-18.432v23.712zm10.752-33.216h17.76q3.072 0 5.376-1.632 2.304-1.728 3.552-4.608 1.344-2.88 1.344-6.528 0-3.744-1.536-6.624t-4.032-4.416q-2.4-1.632-5.28-1.632h-17.184z"/>
					<path d="m121.62 128.53q-5.856 0-10.656-2.016-4.704-2.112-8.16-5.664-3.456-3.648-5.376-8.256-1.824-4.704-1.824-9.984 0-7.104 3.264-12.96 3.264-5.952 9.12-9.504 5.856-3.648 13.728-3.648t13.536 3.648q5.76 3.552 8.928 9.408t3.168 12.576q0 1.152-0.096 2.208-0.096 0.96-0.192 1.632h-40.224q0.288 4.416 2.4 7.776 2.208 3.264 5.568 5.184 3.36 1.824 7.2 1.824 4.224 0 7.968-2.112 3.84-2.112 5.184-5.568l9.024 2.592q-1.632 3.648-4.992 6.624-3.264 2.88-7.776 4.608-4.512 1.632-9.792 1.632zm-15.072-29.568h30.336q-0.288-4.32-2.496-7.584-2.112-3.36-5.472-5.184-3.264-1.92-7.296-1.92-3.936 0-7.296 1.92-3.264 1.824-5.376 5.184-2.112 3.264-2.4 7.584z"/>
					<path d="m184.28 86.484q-6.144 0.096-10.944 2.784-4.704 2.688-6.72 7.584v30.72h-10.56v-50.208h9.792v11.232q2.592-5.184 6.816-8.256 4.224-3.168 8.928-3.456 0.96 0 1.536 0 0.672 0 1.152 0.096z"/>
					<path d="m191.87 127.57v-50.208h10.56v50.208zm0-58.464v-11.616h10.56v11.616z"/>
					<path d="m237.68 128.53q-5.952 0-10.656-2.016-4.704-2.112-8.16-5.76-3.36-3.648-5.184-8.256-1.824-4.704-1.824-9.984 0-5.28 1.824-9.984t5.184-8.256q3.456-3.648 8.16-5.664 4.8-2.112 10.656-2.112t10.56 2.112q4.8 2.016 8.16 5.664 3.456 3.552 5.28 8.256t1.824 9.984q0 5.28-1.824 9.984-1.824 4.608-5.28 8.256-3.36 3.648-8.16 5.76-4.704 2.016-10.56 2.016zm-14.976-25.92q0 4.8 2.016 8.64t5.376 6.048 7.584 2.208q4.128 0 7.488-2.208 3.456-2.304 5.472-6.144 2.016-3.936 2.016-8.64 0-4.8-2.016-8.64t-5.472-6.048q-3.36-2.304-7.488-2.304-4.224 0-7.584 2.304t-5.376 6.144q-2.016 3.744-2.016 8.64z"/>
					<path d="m269.7 102.52q0-7.2 2.88-13.056 2.976-5.952 8.064-9.408 5.088-3.552 11.712-3.552 5.76 0 10.368 2.976 4.704 2.976 7.296 7.392v-29.376h10.56v58.176q0 1.824 0.672 2.592t2.208 0.864v8.448q-2.976 0.48-4.608 0.48-2.976 0-5.088-1.728-2.016-1.728-2.112-4.128l-0.096-3.744q-2.88 4.8-7.776 7.488-4.896 2.592-10.176 2.592-5.184 0-9.6-2.016-4.32-2.016-7.584-5.664-3.168-3.648-4.992-8.352-1.728-4.704-1.728-9.984zm40.32 7.008v-13.152q-1.056-3.072-3.456-5.472-2.304-2.496-5.28-3.936-2.88-1.44-5.76-1.44-3.36 0-6.144 1.44-2.688 1.44-4.704 3.84-1.92 2.4-2.976 5.472t-1.056 6.432q0 3.456 1.152 6.528 1.152 2.976 3.264 5.376 2.208 2.304 4.992 3.648 2.88 1.248 6.24 1.248 2.112 0 4.224-0.768 2.208-0.768 4.128-2.112 2.016-1.344 3.36-3.168 1.44-1.824 2.016-3.936z"/>
					<path d="m333.99 127.57v-50.208h10.56v50.208zm0-58.464v-11.616h10.56v11.616z"/>
					<path d="m380 128.53q-5.856 0-10.656-2.016-4.704-2.112-8.16-5.76t-5.376-8.352q-1.824-4.704-1.824-9.984 0-7.104 3.168-12.96 3.264-5.856 9.024-9.408 5.856-3.552 13.824-3.552 7.68 0 13.344 3.456 5.76 3.36 8.448 9.024l-10.272 3.264q-1.728-3.168-4.896-4.896-3.072-1.824-6.816-1.824-4.224 0-7.68 2.208-3.36 2.112-5.376 5.952-1.92 3.744-1.92 8.736 0 4.8 2.016 8.736 2.016 3.84 5.376 6.144 3.456 2.208 7.68 2.208 2.592 0 4.992-0.864 2.496-0.96 4.32-2.496 1.824-1.632 2.592-3.552l10.368 3.072q-1.632 3.744-4.896 6.624-3.168 2.88-7.584 4.608-4.32 1.632-9.696 1.632z"/>
					<path d="m407.22 112.88q0-4.8 2.688-8.352 2.784-3.648 7.584-5.568 4.8-2.016 11.136-2.016 3.36 0 6.816 0.48 3.552 0.48 6.24 1.536v-3.168q0-5.28-3.168-8.256t-9.12-2.976q-4.224 0-7.968 1.536-3.744 1.44-7.968 4.128l-3.552-7.104q4.992-3.36 9.984-4.992 5.088-1.632 10.656-1.632 10.08 0 15.84 5.376 5.856 5.28 5.856 15.072v18.72q0 1.824 0.576 2.592 0.672 0.768 2.208 0.864v8.448q-1.44 0.288-2.592 0.384t-1.92 0.096q-3.36 0-5.088-1.632t-2.016-3.84l-0.288-2.88q-3.264 4.224-8.352 6.528t-10.272 2.304q-4.992 0-8.928-2.016-3.936-2.112-6.144-5.664t-2.208-7.968zm31.968 3.072q1.152-1.248 1.824-2.496t0.672-2.208v-5.76q-2.688-1.056-5.664-1.536-2.976-0.576-5.856-0.576-5.76 0-9.408 2.304-3.552 2.304-3.552 6.336 0 2.208 1.152 4.224 1.248 2.016 3.456 3.264 2.304 1.248 5.664 1.248 3.456 0 6.624-1.344t5.088-3.456z"/>
					<path d="m465.15 57.492h10.56v55.584q0 3.84 1.152 4.896t2.88 1.056q1.92 0 3.552-0.384 1.728-0.384 2.976-0.96l1.536 8.352q-2.304 0.96-5.472 1.632t-5.664 0.672q-5.376 0-8.448-2.976-3.072-3.072-3.072-8.448z"/>
				</g>
			</g>
		</svg>
		<span>Series <?= $issue['series'] ?></span>
		<span>Issue <?= $issue['issue'] ?></span>
	</h1>
</section>

<section class="toc">

<h2>In this issue</h2>

<ol>
	<?php foreach ($issue['storyData'] as $info) : ?>
		<li>
			<h3><?= $info['title'] ?></h3>
			<?php if (!empty($info['synopsis'])) : ?>
				<p><?= $info['synopsis'] ?></p>
			<?php endif; ?>
			<?php if (isset($info['rating'])) : ?>
				<p class="rating">
					<b>Rated <?=
						Rating::tryFrom($info['rating'])?->description() ?? 'Unknown'
					?></b><?= empty($info['warnings']) ? '' : ': ' . implode(', ', $info['warnings']) ?>
				</p>
			<?php endif ?>
	<?php endforeach; ?>
</ol>

<?php if (!empty($issue['cover'])) : ?>
<p class="cover-credit">
	Cover<?= empty($issue['cover']['title']) ? ' by' : ':' ?>
	<?php if (!empty($issue['cover']['link'])) : ?><a href="<?= $issue['cover']['link'] ?>"><?php endif; ?>
		<?= empty($issue['cover']['title']) ? '' : '&quot;' . $issue['cover']['title'] . '&quot; by'?>
		<?= $issue['cover']['artist'] ?>
	<?php if (!empty($issue['cover']['link'])) : ?></a><?php endif; ?>
</p>
<?php endif; ?>

<p class="colophon"><?= $issue['colophon'] ?></p>

</section>

<?php foreach ($issueHtml as $index => $story) : ?>
	<?php $info = $issue['storyData'][$index]; ?>
	<section>
	<h2><?= $info['title'] ?></h2>
	<?= $story ?>
	<?php if (!empty($info['stinger'])) : ?>
		<p class="tbc"><?= $info['stinger'] ?></p>
	<?php endif; ?>
	</section>
<?php endforeach; ?>
</body></html>