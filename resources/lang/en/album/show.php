<?php
return [
	'title' => 'Viewing Album: ',

	'form' => [
		'edit-album' =>
		[
			'danger-zone' =>
			[
				'section' =>
				[
					'description' => '',
					'title' => 'Danger Zone',
				],
				'delete-album' =>
				[
					'submit' => 'Delete Album',
					'title' => 'Once you delete an album, there is no going back.',
				],
			],
			'details' =>
			[
				'section' =>
				[
					'description' => 'Change the details of the album.',
					'title' => 'Album Details',
				],
				'description' => 'Description',
				'duplicate_check' =>
				[
					'title' => 'Duplicate Check',
					'description' => 'Whether to automatically check for duplicates when uploading photos. Depending on the number of photos in the album, this could take some time. Instead of being done when uploading it is possible to run a full check, of every photo, within the album itself at any point.',
				],
				'name' => 'Name',
				'submit' => 'Update',
			],
		],
	],

	'links' => [
		'edit-album' => 'Edit Album',
		'edit-photo' => 'Edit Photo',
		'jump-to' => 'Jump to Edit Album?',
		'upload-photos' => 'Upload Photos',
		'view-album' => 'View Album',
	],

	'modals' => [
		'edit-photo' => [
			'cover_photo' => 'Use this photo as the Cover Photo?',
			'date_taken' => 'Date and Time Taken',
			'description' => 'Description',
			'name' => 'Name',
		],
		'upload-photos' => [
			'submit' => 'Upload',
		],
	],

	'text' => [
		'no-photos' => 'There are no photos in this album.',
		'subtitle' => '',
	],
];
