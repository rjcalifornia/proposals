<?php


//elgg_pop_breadcrumb();
elgg_push_collection_breadcrumbs('object', 'proposals');

elgg_register_title_button('proposals', 'add', 'object', 'proposals');

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'proposals',
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('proposals:none'),
	'preload_owners' => true,
	'preload_containers' => true,
	'distinct' => false,
));

$title = elgg_echo('collection:object:proposals:all');

$sidebar = elgg_view('custom/full',  ['page' => 'all']);

$body = elgg_view_layout('content', array(
	'filter_value' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
    