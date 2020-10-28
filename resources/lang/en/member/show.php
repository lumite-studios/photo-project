<?php
return [
	'title' => 'Viewing Member: ',

	'form' => [
		'edit-member' => [
			'danger-zone' => [
				'section' => [
					'description' => 'Once you delete a member, there is no going back.',
					'title' => 'Danger Zone',
				],
				'delete' => [
					'submit' => 'Delete Member',
					'title' => 'Any tags of this member will be removed from photos.',
				],
			],
			'details' => [
				'section' => [
					'description' => 'Change the details of the member.',
					'title' => 'Member Details',
				],
				'birthday' => 'Birthday',
				'description' => 'Description',
				'father' => 'Father',
				'mother' => 'Mother',
				'name' => 'Name',
				'submit' => 'Update',
			],
		],
		'edit-photo' => [
			'cover_photo' => 'Use this photo as the Cover Photo?',
			'submit' => 'Save Changes',
		],
	],

	'links' => [
		'jump-to' => 'Jump to Edit Member?',
	],

	'modals' => [
		//
	],

	'text' => [
		'deleted-member' => 'Successfully deleted this member!',
		'no-photos' => 'This member has not been tagged in any photos.',
		'subtitle' => 'View all the photos this member has been tagged in.',
		'updated-member' => 'Successfully updated this member!',
	],
];
