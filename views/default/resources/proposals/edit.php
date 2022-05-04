<?php
/**
 * Add bookmark page
 *
 * @package Elggproposals
 */
use Elgg\Exceptions\Http\EntityNotFoundException;
elgg_gatekeeper();

$proposals_guid = elgg_extract('guid', $vars);
$proposals = get_entity($proposals_guid);

 

//$twig = $vars['twig'];
elgg_require_js("proposals/external_video_validation");

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('proposals:edit');
elgg_push_breadcrumb($title);
$form_vars = array('enctype' => 'multipart/form-data');
$vars = proposals_prepare_form_vars($proposals);
//$vars['twig'] = $twig;
$content = elgg_view_form('proposals/save', $form_vars, $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);