<?php
$page = elgg_extract('page', $vars);
$proposalGuid = elgg_extract('proposal_guid', $vars);
$twig = elgg_extract('twig', $vars);
$guid = elgg_get_logged_in_user_entity()->guid;


$supportNeeded = elgg_get_plugin_setting('support_needed_setting', 'proposals');

$countSupporters = 0;
$showSupportButton = true;
$userSupport = false;
$supporters = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'supports',        
    'container_guid' => $proposalGuid,	
    //'limit' => 1,
    'no_results' => elgg_echo("file:none"),
    'preload_owners' => false,
    'preload_containers' => false,
    'distinct' => false,
));

foreach($supporters as $sp){
    $countSupporters++;
}


$supporters = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'supports',        
    'container_guid' => $proposalGuid,
    'owner_guid' => $guid
));
//var_dump($supporters);
if(!empty($supporters)){
    $showSupportButton = false;
}

if($guid == false){
    $showAuthButton = true;
}

if(!empty($supporters) && $guid == true){
    //$showSupportButton = false;
    $userSupport = true;
}
//var_dump($proposalSupports);

    $supportUrl = "action/proposals/supports?guid=$proposalGuid";


	$supportProposal = elgg_view('output/url', array(
		'href' => $supportUrl,
		'text' => elgg_echo('proposal:support'),
		'class' => 'elgg-menu-content elgg-button elgg-button-action',
		'confirm' => true,
	));

    $data['support_button'] = new \Twig\Markup($supportProposal, 'UTF-8');
    $data['support_validation'] = $showSupportButton;
    $data['supporters'] = $countSupporters;
    $data['supporting_proposal'] = $userSupport;
    $data['auth'] = $showAuthButton;
    $data['support_needed'] = $supportNeeded;

    echo $twig->render('layouts/sidebar.html.twig', 
    [
        'data' => $data,
    ]);
//var_dump($twig);
