<?php
/**
 * Add bookmark page
 *
 * @package Bookmarks
 */

use Elgg\Exceptions\Http\EntityPermissionsException;

$guid = elgg_extract('guid', $vars);
if (!$guid) {
	$guid = elgg_get_logged_in_user_guid();
}

$container = get_entity($guid);

elgg_entity_gatekeeper($guid);

$page_owner = elgg_get_page_owner_entity();

//elgg_require_js("proposals/external_video_validation");

// Make sure user has permissions to add to container
if (!$container->canWriteToContainer(0, 'object', 'proposals')) {
	throw new EntityPermissionsException();
}

//$twig = $vars['twig'];


$title = elgg_echo('proposals:add');
elgg_push_breadcrumb($title);
$form_vars = array('enctype' => 'multipart/form-data');
$vars = proposals_prepare_form_vars();
//$vars['twig'] = $twig;
$content = elgg_view_form('proposals/save', $form_vars, $vars);
//$content = '3333';
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);