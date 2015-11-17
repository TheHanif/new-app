<?php

// Init array
$builtin_medias = array();

$builtin_medias[] = array(
		'key' => 'thumbnail'
		,'description' => 'Thumbnail'
		, 'crop' => true
	);

$builtin_medias[] = array(
		'key' => 'small'
		,'description' => 'Small'
		, 'crop' => false
	);

$builtin_medias[] = array(
		'key' => 'medium'
		,'description' => 'Medial'
		, 'crop' => false
	);

$builtin_medias[] = array(
		'key' => 'large'
		,'description' => 'Large'
		, 'crop' => false
	);

$builtin_medias[] = array(
		'key' => 'photo'
		,'description' => 'Photo'
		, 'crop' => true
	);

foreach ($builtin_medias as $builtin_medias) {
	register_media_size($builtin_medias);
};