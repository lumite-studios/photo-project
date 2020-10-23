<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteToFamily extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * The code the invite needs.
	 * @var string
	 */
	public $code;

	/**
	 * The code the invite needs.
	 * @var string
	 */
	public $email;

	/**
	 * The family the user is invited to join.
	 * @var string
	 */
	public $family;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $family, string $code)
    {
		$this->code = $code;
		$this->email = array_key_exists(0, $this->to) ? $this->to[0] : null;
        $this->family = $family;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('emails/invite-to-family.title'))->markdown('emails.invite-to-family');
    }
}
