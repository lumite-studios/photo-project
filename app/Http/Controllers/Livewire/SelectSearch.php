<?php
namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class SelectSearch extends Component
{
	public $initialOptions;
	public $query = null;
	public $options;
	public $term;

	/**
	 * Setup the components required data.
	 */
	public function mount(Collection $options, string $term = 'name')
    {
		$this->options = $this->initialOptions = $options;
		$this->term = $term;
        $this->clear();
	}

	/**
	 * Render the livewire component.
	 */
	public function render()
	{
        return view('livewire.select-search');
	}

	/**
	 * Reset the search.
	 */
	public function clear()
	{
		$this->query = null;
		$this->options = $this->initialOptions;
		$this->highlightIndex = 0;
	}

    public function updatedQuery()
    {
		$query = $this->query;
		$term = $this->term;
        $this->options = $this->options->filter(function($value, $key) use($query, $term) {
			return Str::contains(strtolower($value[$term]), strtolower($query));
		});
		$this->emitUp('selectedSearch', $query);
	}

	public function selectOption(int $id)
	{
		$selected = $this->options->where('id', '=', $id)->first();
		$this->query = $selected[$this->term];
		$this->options = collect();
		$this->emitUp('selectedSearch', $selected);
	}
}
