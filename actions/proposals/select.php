<?php

if(!elgg_is_admin_logged_in()){
    register_error(elgg_echo('not:allowed'));
	forward("proposals");
}

//$ia = elgg_set_ignore_access(true);
//elgg_set_ignore_access(true);
$proposalGuid = get_input('guid');

$proposals = get_entity($proposalGuid);
$user = elgg_get_logged_in_user_entity();

$proposals->selected = true;
$proposals->updated_by = $user->guid;
$proposals->save();
system_message("Proposal was marked as selected");
forward($proposals->getURL());