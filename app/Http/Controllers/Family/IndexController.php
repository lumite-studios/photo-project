<?php
namespace App\Http\Controllers\Family;

use App\Mail\InviteToFamily;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class IndexController extends Component
{
	public $family;

	public $invites;

	/**
	 * The form state.
	 * @var array
	 */
	public $state = [];

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
		$this->setInvites();
		$this->clearState();
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

	/**
	 * Set the invites from the family.
	 */
	private function setInvites()
	{
		$this->invites = $this->family->invites->map(function($value)
		{
			return ['email' => $value->email, 'code' => $value->code];
		});
	}

	/**
	 * Send an invite.
	 */
	public function sendInvite()
	{
		if($this->family->invites()->where('email', '=', $this->state['invite']['name'])->first() || $this->family->users()->where('email_address', '=', $this->state['invite']['name'])->first())
		{
			$this->emit('toast', __('family/index.text.error-invite'), 'error');
			return;
		}

		$permissions = collect($this->state['invite'])->filter(function($value, $key) {
			return $value === true;
		})->keys()->toJson();

		$code = Str::random(15);
		$this->family->invites()->create([
			'email' => $this->state['invite']['name'],
			'code' => $code,
			'permissions' => $permissions,
		]);

		Mail::to($this->state['invite']['name'])->send(new InviteToFamily($this->family->name, $code, $this->state['invite']['name']));

		$this->clearState();
		$this->family->refresh();
		$this->setInvites();
	}

	/**
	 * Remove an invite.
	 *
	 * @param string $invite
	 */
	public function removeInvite(string $invite = null)
	{
		$invite = $this->family->invites()->where('email', '=', $invite)->first();
		$invite->delete();

		$this->family->refresh();
		$this->setInvites();
		$this->emit('toast', 'Deleted Invite', 'success');
	}

	/**
	 * Clear the state.
	 */
	private function clearState()
	{
		$this->state = [
			'invite' => [
				'name' => null,
				'view' => true,
				'invite' => false,
				'upload' => true,
				'edit' => true,
				'delete' => true,
				'admin' => false,
			],
			'name' => $this->family->name,
		];
	}
}
