<?php
namespace App\Traits;

use App\Traits\DisplayPhotosOptions;
use Carbon\Carbon;

trait DisplayPhotos
{
	use DisplayPhotosOptions;

	/**
	 * The current count of photos.
	 * @var integer
	 */
	public $count = 0;

	/**
	 * The last loaded photo.
	 * @var string
	 */
	public $last = null;

	/**
	 * The model to load the photos from.
	 * @var mixed
	 */
	public $model;

	/**
	 * The number of months to load.
	 * @var integer
	 */
	private $months = 3;

	/**
	 * The photos that have been loaded, ungrouped.
	 * @var Collection
	 */
	public $_photos = [];

	/**
	 * The total number of photos.
	 * @var integer
	 */
	public $total = 0;

	/**
	 * Whether there are more photos to load.
	 */
	public function getCanLoadMoreProperty()
	{
		return count($this->_photos) < $this->total;
	}

	/**
	 * Get the photos.
	 * Has to be computed, as property will only allow an
	 * array to be returned from the collection and not
	 * the full models.
	 */
	public function getPhotosProperty()
	{
		if($this->total === 0)
		{
			return collect();
		}

		// set the variables
		$sort = $this->getSort(false);
		$order = $this->getOrder($sort);
		$group = $this->getGroup();
		$last = $this->getLastLoadedPhoto();

		// using the last loaded photo,
		// get the next few months
		$next = $sort === '>'
			? Carbon::parse($last->date_taken)->subMonths($this->months)->toDateTimeString()
			: Carbon::parse($last->date_taken)->addMonths($this->months)->toDateTimeString();

		// get the photos
		$this->_photos = $photos = $this->model->photos()
					->orderBy('date_taken', $order)
					->orderBy('id', $order)
					->whereDate('date_taken', $sort, $next)
					->get();

		// update the current photos count
		$this->count = $photos->count();

		// return the photos grouped by the date
		return $photos->groupBy(function($value, $key) use($group) {
			return Carbon::parse($value->date_taken)->format($group);
		});
	}

	/**
	 * Check if there are photos.
	 */
	public function getHasPhotosProperty()
	{
		return count($this->_photos) > 0;
	}

	/**
	 * Show the next months.
	 */
	public function loadMorePhotos()
	{
		if($this->canLoadMore)
		{
			$this->setLast();
			$this->photos;
		}
	}

	/**
	 * Update the meta.
	 *
	 * @param string $meta
	 * @param string $value
	 */
	public function updateMeta(?string $meta = null, ?string $value = null)
	{
		if($meta === 'sort')
		{
			$this->clearLast();
		}
		$this->meta[$meta]['value'] = $value;
	}

	/**
	 * Set the last photos loaded to null if needed.
	 *
	 * @param mixed $val
	 */
	public function updatedMeta($val)
	{
		if(array_key_exists($val, $this->meta['sort']['options']))
		{
			$this->clearLast();
		}
	}

	/**
	 * Reset the last loaded data.
	 */
	private function clearLast()
	{
		$this->count = 0;
		$this->last = null;
	}

	/**
	 * Get the group.
	 */
	private function getGroup()
	{
		return ['year' => 'Y', 'month' => 'F Y', 'day' => 'jS F Y'][$this->meta['group']['value']];
	}

	/**
	 * Get the last loaded photo.
	 */
	private function getLastLoadedPhoto()
	{
		$sort = $this->getSort(false);
		$order = $this->getOrder($sort);

		if($this->last !== null)
		{
			$_sort = $this->getSort(true);
			return $this->model->photos()->orderBy('date_taken', $order)->whereDate('date_taken', $_sort, $this->last['date_taken'])->first();
		}
		return $this->model->photos()->orderBy('date_taken', $order)->first();
	}

	/**
	 * Get the order using the sort.
	 *
	 * @param string $sort
	 */
	private function getOrder(string $sort)
	{
		return $sort === '<' ? 'ASC' : 'DESC';
	}

	/**
	 * Get the sort direction.
	 *
	 * @param boolean $reverse
	 */
	private function getSort(bool $reverse = false)
	{
		if($reverse)
		{
			return $this->meta['sort']['value'] === '>' ? '<' : '>';
		}
		return $this->meta['sort']['value'];
	}

	/**
	 * Set the last loaded photo.
	 */
	private function setLast()
	{
		$this->last = $this->_photos->last();
	}
}
