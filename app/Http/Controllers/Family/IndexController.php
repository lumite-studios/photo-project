<?php
namespace App\Http\Controllers\Family;

use Livewire\Component;

class IndexController extends Component
{
	/**
	 * The form state.
	 * @var array
	 */
	public $state = [
		'name' => null,
	];

	/**
	 * The users in this family.
	 * @var Collection
	 */
	public $users;

    protected $rules = [
        'users.*.admin' => ['boolean', 'required'],
        'users.*.view' => ['boolean', 'required'],
        'users.*.invite' => ['boolean', 'required'],
        'users.*.upload' => ['boolean', 'required'],
        'users.*.edit' => ['boolean', 'required'],
        'users.*.delete' => ['boolean', 'required'],
    ];

	/**
	 * Setup the components required data.
	 */
	public function mount()
	{
		$this->state['name'] = auth()->user()->currentFamily->name;
		$this->users = auth()->user()->currentFamily->users->map(function($user)
		{
			$user['admin'] = $user->canAdmin();
			$user['view'] = $user->canView();
			$user['invite'] = $user->canInvite();
			$user['upload'] = $user->canUpload();
			$user['edit'] = $user->canEdit();
			$user['delete'] = $user->canDelete();
			return $user;
		});
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
		return view('family.index')
			->layout('layouts.app', [
				'title' => __('family/index.title'),
				'subtitle' => __('family/index.text.subtitle'),
			]);
	}

	public function update()
	{

	}

	public function edit($user)
	{
		dd($user);
	}
}
