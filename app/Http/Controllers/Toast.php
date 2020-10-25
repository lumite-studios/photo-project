<?php

namespace App\Http\Controllers;

use Livewire\Component;

class Toast extends Component
{
	/**
	 * An array of listeners for events.
	 * @var array
	 */
	protected $listeners = ['toast'];

	/**
	 * The classes to apply to the toast message,
	 * depending on the alert type.
	 * @var array
	 */
	public $classes = [
		'error' => ' bg-red-500 text-white',
		'info' => ' bg-blue-500 text-white',
		'success' => ' bg-green-500 text-white',
		'warning' => ' bg-orange-500 text-white',
	];

	/**
	 * The message to send.
	 * @var string
	 */
	public $message = null;

	/**
	 * The type of alert.
	 * @var string
	 */
	public $type = 'success';

	/**
	 * Send a toast message.
	 *
	 * @param string $message
	 * @param string $type
	 */
	public function toast(string $message, string $type = 'success')
	{
		$this->message = $message;
		$this->type = $type;
		$this->dispatchBrowserEvent('toast-message-show');
	}

	/**
	 * Render the livewire component.
	 */
    public function render()
    {
        return view('toast');
    }
}
