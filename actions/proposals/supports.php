<?php

if(!elgg_is_logged_in){
    register_error(elgg_echo('not:allowed'));
	forward("proposals");
}
$ia = elgg_set_ignore_access(true);
elgg_set_ignore_access(true);
$proposalGuid = get_input('guid');
$proposals = get_entity($proposalGuid);
$user = elgg_get_logged_in_user_entity();


$findUserSupport = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'supports',        
    'container_guid' => $proposalGuid,
    'owner_guid' => $user->guid,
));

if(!empty($findUserSupport)){
    register_error(elgg_echo('proposal:support:twice'));
	forward("proposals");
}

$support = new ElggObject;

$support->subtype = 'supports';
$support->container_guid = $proposals->guid;
$support->owner_guid = $user->guid;
$support->access_id = ACCESS_PUBLIC;
$support->save();

if ($support) {
    
    elgg_create_river_item(array(
		'view' => 'river/object/proposals/support',
		'action_type' => 'support',
		'subject_guid' => $user->guid,
		'object_guid' => $proposals->guid,
		'target_guid' =>  $proposals->getGUID(),
	));


    system_message("You are supporting this proposal");
    forward($proposals->getURL());
 } 