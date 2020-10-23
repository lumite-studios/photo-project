<?php
namespace App\Http\Controllers\Family;

use App\Mail\InviteToFamily;
use App\Models\Family;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateController extends Component
{
	/**
	 * The invite to add.
	 * @var string
	 */
	public $invite = null;

	/**
	 * The create form data.
	 * @var array
	 */
	public $state = [
		'invites' => [],
		'name' => '',
	];

	/**
	 * Setup the components required data.
	 */
	public function mount()
	{
		$this->state['name'] = __('family/create.text.family-name', ['surname' => explode(' ',auth()->user()->name)[1]]);
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('family.create')
			->layout('layouts.app', [
				'title' => __('family/create.title'),
				'subtitle' => __('family/create.text.subtitle'),
			]);
	}

	/**
	 * Add an invite to the list to send.
	 */
	public function addInvite()
	{
		$this->validate([
			'invite' => ['email', 'required'],
		]);

		$this->state['invites'][] = $this->invite;
		$this->invite = null;
	}

	/**
	 * Remove an invite.
	 *
	 * @param string $invite
	 */
	public function removeInvite(string $invite = null)
	{
		$this->state['invites'] = array_diff($this->state['invites'], [$invite]);
	}

	/**
	 * Create a family.
	 */
	public function create()
	{
		$this->validate([
			'state.name' => ['required', 'string'],
		]);

		$family = new Family;
		$family->name = $this->state['name'];
		$family->save();

		// add the auth as a user of this family
		$family->users()->attach(auth()->user()->id, ['permissions' => json_encode(['*'])]);

		// create the default "Unsorted" album
		$family->albums()->create([
			'name' => __('family/create.text.unsorted.name'),
			'slug' => null,
			'description' => __('family/create.text.unsorted.description'),
			'cover_photo_path' => null,
			'editable' => false,
			'duplicate_check' => false,
		]);

		foreach($this->state['invites'] as $email)
		{
			$code = Str::random(15);
			$invite = $family->invites()->create([
				'email' => $email,
				'code' => $code,
			]);

			Mail::to($email)->send(new InviteToFamily($family->name, $code));
		}

		return redirect()->route('dashboard');
	}
}
