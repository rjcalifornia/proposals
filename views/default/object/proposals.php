<?php
$full = elgg_extract('full_view', $vars, FALSE);
$proposals = elgg_extract('entity', $vars, FALSE);
$site_url = elgg_get_site_url();

if (!$proposals) {
	return;
}

$getDocuments = [];


$owner = $proposals->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$categories = elgg_view('output/categories', $vars);

$vars['owner_url'] = "proposals/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

$subtitle = "$by_line $comments_link $categories";

$metadata = '';
if (!elgg_in_context('widgets')) {
	// only show entity menu outside of widgets
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'proposals',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}


if ($full) {
    

    $singleProposal =  get_entity($proposals->guid);

    $tags = $singleProposal->tags;
    $proposalDocuments = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'proposals_documents',        
        'container_guid' => $proposals->guid,	
        //'limit' => 1,
        'no_results' => elgg_echo("file:none"),
        'preload_owners' => true,
        'preload_containers' => true,
        'distinct' => false,
    ));

    $descriptiveImage = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'proposals_descriptive_image',        
        'container_guid' => $proposals->guid,	
        'limit' => 1,
        'no_results' => elgg_echo("file:none"),
        'preload_owners' => true,
        'preload_containers' => true,
        'distinct' => false,
    ));

    $descriptiveImageUrl = elgg_get_download_url($descriptiveImage[0]);
    $descriptiveImageFilename = $descriptiveImage[0]->title;

    $proposalImage = ['url'=> $descriptiveImageUrl, 'filename' => $descriptiveImageFilename];

    foreach ($proposalDocuments as $prDoc) {
        $document = get_entity($prDoc->guid);
        $documentUrl = elgg_get_download_url($document);

        $getDocuments[] = ['filename' => $document->title, 'url' => $documentUrl];
      
    }


    //var_dump($proposalDocuments);
    $data['proposals'] = $singleProposal->toObject();
    $data['summary'] =  $singleProposal->summary;
    $data['external_video'] =  $singleProposal->external_video;
    $data['video_type'] =  $singleProposal->external_video_type;
    $data['proposal_documents'] = $getDocuments;
    $data['proposal_descriptive_image'] = $proposalImage;
    $data['tags'] = $tags;
    $data['site_url'] = $site_url;

    

    echo $vars['twig']->render('pages/view_proposal.html.twig', 
    [
        'data' => $data,
    ]);
} else {
	// brief view

	$params = array(
		'entity' => $proposals,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
		'icon' => $owner_icon,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);

}