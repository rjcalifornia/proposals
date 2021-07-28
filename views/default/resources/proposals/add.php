<?php
/**
 * Add bookmark page
 *
 * @package Bookmarks
 */

elgg_gatekeeper();
elgg_group_gatekeeper();

$page_owner = elgg_get_page_owner_entity();

elgg_require_js("proposals/external_video_validation");

// Make sure user has permissions to add to container
if (!$page_owner || !$page_owner->canWriteToContainer(0, 'object', 'proposals')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$twig = $vars['twig'];


$title = elgg_echo('proposals:add');
elgg_push_breadcrumb($title);
$form_vars = array('enctype' => 'multipart/form-data');
$vars = proposals_prepare_form_vars();
$vars['twig'] = $twig;
$content = elgg_view_form('proposals/save', $form_vars, $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);