<?php
namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
	/**
	 * The subtitle.
	 * @var string
	 */
	public $subtitle = null;

	/**
	 * The title.
	 * @var string
	 */
	public $title = null;

    /**
     * Create the component instance.
     *
     * @param string $title
     * @param string $subtitle
     * @return void
     */
    public function __construct(string $title = null, string $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
