<?php

$site_url = elgg_get_site_url();
$twig = elgg_extract('twig', $vars);

$title = elgg_echo('tagcloud:site_cloud');
$options = array(
	'threshold' => 0,
	'limit' => 100,
	'tag_name' => 'tags',
);
$content = elgg_view_tagcloud($options);

$proposalTags = elgg_get_tags([
    'type' => 'object', 
    'subtype' => 'proposals',
 ]);
 $data['site_url'] = $site_url;

$data['tags'] = $proposalTags; 
echo $twig->render('layouts/all_sidebar.html.twig', 
    [
        'data' => $data,
    ]);