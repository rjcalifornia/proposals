<?php


elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('proposals'));

//elgg_register_title_button('proposals', 'add', 'object', 'proposals');

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'proposals',
    //'selected' => 1,
	'full_view' => false,
	'view_toggle_type' => false,
	'no_results' => elgg_echo('proposals:none'),
	'preload_owners' => true,
	'preload_containers' => true,
	'distinct' => false,
));

$options = array(
'type' => 'object',
'subtype' => 'proposals',
'full_view' => false,
    'metadata_names' =>array('selected'),
    'metadata_values' =>array(true),
    'limit' => 8,
    'no_results' => elgg_echo('videolist:none'),
    'preload_owners' => true,
    'distinct' => false,
    'pagination' => false,
    'offset'=>0,

);

$test = elgg_list_entities_from_metadata($options);
$title = elgg_echo('proposals:selected');

$sidebar = elgg_view('custom/full', ['twig'=> $vars['twig']]);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $test,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
    
/*
$renderPage = elgg_view_page($title, $body);
$data['body'] = new \Twig\Markup($renderPage, 'UTF-8');
echo $vars['twig']->render('pages/all.html.twig', 
        [
            'data' => $data,
        ]);*/