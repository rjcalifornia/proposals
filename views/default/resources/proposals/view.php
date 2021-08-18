<?php

$page_type = elgg_extract('page_type', $vars);
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'proposals');
//elgg_group_gatekeeper();

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



//elgg_push_breadcrumb($proposals->title);
//elgg_push_entity_breadcrumbs($proposals, false);
elgg_push_collection_breadcrumbs('object', 'proposals');
$params['content'] = elgg_view_entity($proposals, array('full_view' => true, 
                                                      //  'twig'=> $vars['twig']
                                                    ));




$params['sidebar'] = elgg_view('custom/sidebar', [
					'page' => $page_type,
					//'twig'=> $vars['twig'],
					'proposal_guid' => $proposals->guid
				]);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
