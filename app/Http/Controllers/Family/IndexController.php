<?php
namespace App\Http\Controllers\Family;

use App\Models\User;
use Livewire\Component;

class IndexController extends Component
{
	public $family;

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
	public $users = [];

	/**
	 * The rules for the properties.
	 * @var array
	 */
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
		$this->family = auth()->user()->currentFamily;
		if($this->family !== null)
		{
			$this->state['name'] = $this->family->name;
			$this->users = $this->family->users->map(function($user)
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

	/**
	 * Update the family details.
	 */
	public function update()
	{
		if(auth()->user()->canAdmin())
		{
			$this->validate([
				'state' => ['array', 'required'],
				'state.name' => ['max:255', 'required', 'string'],
			]);

			$family = auth()->user()->currentFamily;
			$family->name = $this->state['name'];
			$family->save();

			$this->emit('toast', __('family/index.text.success-update'), 'success');
		}
	}

	/**
	 * Edit a user's permissions.
	 *
	 * @param array $user
	 */
	public function edit(array $_user)
	{
		if(auth()->user()->canAdmin())
		{
			$user = User::where('id', '=', $_user['id'])->first();
			$_user['view'] ? $user->setPermission('view') : $user->unsetPermission('view');
			$_user['invite'] ? $user->setPermission('invite') : $user->unsetPermission('invite');
			$_user['upload'] ? $user->setPermission('upload') : $user->unsetPermission('upload');
			$_user['edit'] ? $user->setPermission('edit') : $user->unsetPermission('edit');
			$_user['delete'] ? $user->setPermission('delete') : $user->unsetPermission('delete');
			$_user['admin'] ? $user->setPermission('admin') : $user->unsetPermission('admin');

			$this->emit('toast', __('family/index.text.success-edit'), 'success');
		}
	}

	/**
	 * Delete a family.
	 */
	public function delete()
	{
		if(auth()->user()->canDelete())
		{
			$family = $this->family;

			foreach($family->users as $user)
			{
				$user->current_family_id = null;
				$user->save();
			}

			$family->delete();
			$this->skipRender();

			return redirect()->route('dashboard');
		}
	}
}
