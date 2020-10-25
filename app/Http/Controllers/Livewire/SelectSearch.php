<?php
namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class SelectSearch extends Component
{
	/**
	 * The amount of options to take.
	 * @var integer
	 */
	private $amount = 4;

	/**
	 * The filtered options.
	 * @var Collection
	 */
	public $filteredOptions;

	/**
	 * The options that can be taggged.
	 * @var Collection
	 */
	public $options;

	/**
	 * The query string.
	 * @var string
	 */
	public $query = null;

	/**
	 * The search term to lookup against.
	 * @var string
	 */
	public $term;

	/**
	 * Setup the components required data.
	 *
	 * @param Collection $options
	 * @param string $term
	 */
	public function mount(Collection $options, string $term = 'name')
    {
		$this->options = $options;
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
	 *
	 * @param string $query
	 */
	public function clear(string $query = null)
	{
		$this->query = $query;
		$this->filteredOptions = $this->options->take($this->amount);
	}

	/**
	 * Update the filtered options as the query updates.
	 */
    public function updatedQuery()
    {
		$query = $this->query;
		$term = $this->term;

        $this->filteredOptions = $this->options->filter(function($value, $key) use($query, $term) {
			if($query == null)
			{
				return true;
			}
			return Str::contains(strtolower($value[$term]), strtolower($query));
		})->take($this->amount);

		$this->emitUp('selectedSearch', $query);
	}

	/**
	 * Select an option.
	 *
	 * @param integer $id
	 */
	public function selectOption(int $id)
	{
		$selected = $this->options->where('id', '=', $id)->first();

		$this->clear($selected[$this->term]);
		$this->emitUp('selectedSearch', $selected);
	}
}
