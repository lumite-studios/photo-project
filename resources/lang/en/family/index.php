<?php
return [
	'title' => 'Family Settings',

	'form' => [
		'danger-zone' => [
			'section' => [
				'description' => 'One you delete a family, there is no going back.',
				'title' => 'Danger Zone',
			],
			'delete' => [
				'title' => 'All photos within all albums will also be deleted.',
				'submit' => 'Delete Family',
			],
			'confirm' => 'Are you sure you want to delete this family?',
		],
		'details' => [
			'section' => [
				'description' => 'Update information about the family.',
				'title' => 'Edit Details',
			],
			'name' => 'Name',
			'submit' => 'Update',
		],
		'users' => [
			'section' => [
				'description' => 'Users who have access to this family.',
				'title' => 'Users',
			],
			'table' => [
				'name' => 'Name',
				'admin' => 'Admin?',
				'view' => 'View?',
				'invite' => 'Invite?',
				'upload' => 'Upload?',
				'edit' => 'Edit?',
				'delete' => 'Delete?',
			]
		],
	],

	'links' => [
		//
	],

	'modals' => [
		//
	],

	'text' => [
		'subtitle' => '',
	],
];
