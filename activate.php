<?php

if (get_subtype_id('object', 'proposals_documents')) {
	update_subtype('object', 'proposals_documents', 'ProposalPaper');
} else {
	add_subtype('object', 'proposals_documents', 'ProposalPaper');
}

if (get_subtype_id('object', 'proposals_descriptive_image')) {
	update_subtype('object', 'proposals_descriptive_image', 'ProposalFeatured');
} else {
	add_subtype('object', 'proposals_descriptive_image', 'ProposalFeatured');
}