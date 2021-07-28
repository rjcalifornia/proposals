<?php
/**
 * Add bookmark page
 *
 * @package Elggproposals
 */
elgg_gatekeeper();

$bookmark_guid = elgg_extract('guid', $vars);
$bookmark = get_entity($bookmark_guid);

if (!elgg_instanceof($bookmark, 'object', 'proposals') || !$bookmark->canEdit()) {
	register_error(elgg_echo('proposals:unknown_bookmark'));
	forward(REFERRER);
}

$twig = $vars['twig'];
elgg_require_js("proposals/external_video_validation");

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('proposals:edit');
elgg_push_breadcrumb($title);
$form_vars = array('enctype' => 'multipart/form-data');
$vars = proposals_prepare_form_vars($bookmark);
$vars['twig'] = $twig;
$content = elgg_view_form('proposals/save', $form_vars, $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);