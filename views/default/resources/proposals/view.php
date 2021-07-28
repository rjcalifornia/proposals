<?php

$page_type = elgg_extract('page_type', $vars);
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'proposals');
elgg_group_gatekeeper();

$proposals = get_entity($guid);
elgg_extend_view('page/elements/head', 'extras/scripts');

elgg_set_page_owner_guid($proposals->container_guid);

// no header or tabs for viewing an individual proposals
$params = [
	'filter' => '',
	'title' => $proposals->title
];

$container = $proposals->getContainerEntity();
$crumbs_title = $container->name;

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "proposals/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "proposals/owner/$container->username");
}

elgg_push_breadcrumb($proposals->title);

$params['content'] = elgg_view_entity($proposals, array('full_view' => true, 'twig'=> $vars['twig']));

// check to see if we should allow comments
//if ($proposals->comments_on != 'Off' && $proposals->status == 'published') {
	$params['content'] .= elgg_view_comments($proposals);
//}

$params['sidebar'] = elgg_view('proposals/sidebar', array('page' => $page_type));

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
