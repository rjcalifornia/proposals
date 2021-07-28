<?php

$title = get_input('title');
$proposalSummary = get_input('summary');
$proposalText = get_input('description');
$proposalExternalVideo = get_input('external_video');
$scopeOperation = get_input('scope_operation');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');
$container = (int)get_input('container_guid');

$videoType = get_input('external_video_type');

$tagarray = string_to_tag_array($tags);


if ($guid) {
    $proposalsEntity = get_entity($guid);
}else{
    $proposalsEntity = new ElggObject;
}
    $proposalsEntity->subtype = "proposals";
    $proposalsEntity->title = $title;
    $proposalsEntity->summary = $proposalSummary;
    $proposalsEntity->description = $proposalText;
    $proposalsEntity->external_video = $proposalExternalVideo;
    $proposalsEntity->external_video_type = $videoType;
    $proposalsEntity->scope_operation = $scopeOperation;
    $proposalsEntity->access_id = $access_id;
    $proposalsEntity->tags = $tagarray;


   


/*
    foreach (elgg_get_uploaded_files('proposals_documents') as $uploadDocument) {
        $proposalDocument = new ElggFile();
        $proposalDocument->owner_guid = elgg_get_logged_in_user_guid();
        $proposalDocument->container_guid = $proposalsEntity->getGUID();
        if ($proposalDocument->acceptUploadedFile($uploadDocument)) {
                $proposalDocument->save();
        }
}

$descriptiveImage = elgg_get_uploaded_file('descriptive_image');
if ($descriptiveImage != null) {
    $media = new ElggFile();
        $media->owner_guid = elgg_get_logged_in_user_guid();
        //$media->content = 'video';
        $media->container_guid = $proposalsEntity->getGUID();
        if ($media->acceptUploadedFile($descriptiveImage)) {
                $media->save();
        }
}*/

    $proposalsGuid= $proposalsEntity->save();

    $proposalDocuments = elgg_get_uploaded_files('proposals_documents');
    if ($proposalDocuments) {
        
    
    
    foreach (elgg_get_uploaded_files('proposals_documents') as $uploadedDocument) {
            $file = new ProposalPaper();
            $file->title = $file->getFilename();
            $file->container_guid = $proposalsEntity->getGUID();
            $file->access_id = 2;
            if ($file->acceptUploadedFile($uploadedDocument)) {
            $file->save();


            }
    }
}

    $descriptiveImage = elgg_get_uploaded_files('descriptive_image');

    
    if ($descriptiveImage) {
    $uploadedImage = array_shift($descriptiveImage);
    if (!$uploadedImage->isValid()) {
            $error = elgg_get_friendly_upload_error($uploadedImage->getError());
            register_error($error);
            forward(REFERER);
    }
    }

    if($uploadedImage){
        $media =  new ProposalFeatured();
        $media->title = $media->getFilename();
        $media->container_guid = $proposalsEntity->getGUID();
        $media->access_id = 2;
        if ($media->acceptUploadedFile($uploadedImage)) {
        $media->save();
        }
    }
    


    if ($proposalsGuid) {
        system_message("Your proposal was published.");
        forward('proposals');
     } else {
        register_error("The proposal could not be saved.");
        forward(REFERER); // REFERER is a global variable that defines the previous page
     }

