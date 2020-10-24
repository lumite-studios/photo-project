<?php
namespace App\Traits;

trait DisplayPhotosOptions
{
	/**
	 * The various display options.
	 * @var array
	 */
	public $meta = [
		'group' => [
			'value' => 'month',
			'options' => ['year', 'month', 'day'],
		],
		'selected' => [
			'value' => 'none',
			'options' => ['none', 'move', 'delete']
		],
		'sort' => [
			'value' => '>',
			'options' => ['>' => 'newest', '<' => 'oldest']
		],
	];
}
