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

    if(!empty($descriptiveImage)){
        $descriptiveImageUrl = elgg_get_download_url($descriptiveImage[0]);
        $descriptiveImageFilename = $descriptiveImage[0]->title;

        $proposalImage = ['url'=> $descriptiveImageUrl, 'filename' => $descriptiveImageFilename];
    }
        foreach ($proposalDocuments as $prDoc) {
            $document = get_entity($prDoc->guid);
            $documentUrl = elgg_get_download_url($document);

            $getDocuments[] = ['filename' => $document->title, 'url' => $documentUrl];
        
        }
    $admin = elgg_is_admin_logged_in();

    $selectUrl = "action/proposals/select?guid=$singleProposal->guid";
	$selectProposal = elgg_view('output/url', array(
		'href' => $selectUrl,
		'text' => elgg_echo('proposal:mark_selected'),
		'class' => 'pure-material-button-contained select',
		//'confirm' => true,
        'confirm'=>"Are you sure you want to mark this proposal as selected?"
	));
    


    //var_dump($singleProposal->selected);
    $data['admin'] = $admin;
    $data['select_proposal'] = new \Twig\Markup($selectProposal, 'UTF-8');
    $data['proposals'] = $singleProposal->toObject();
    $data['summary'] =  $singleProposal->summary;
    $data['scope'] = $singleProposal->scope_operation;
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
        'summary' => $proposals->summary,
		'content' => $excerpt,
		'icon' => $owner_icon,
	);
	$params = $params + $vars;
	echo elgg_view('custom/summary', $params);

}