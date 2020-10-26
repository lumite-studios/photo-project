<?php

namespace App\Jobs;

use App\Models\Photo;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadPhoto implements ShouldQueue
{
	use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * The photo object.
	 * @var Photo
	 */
	public $photo;

	public $slug;

	public $temp_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Photo $photo, string $slug, string $temp_path)
    {
		$this->temp_path = $temp_path;
		$this->photo = $photo;
		$this->slug = $slug;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if($this->batch()->cancelled())
		{
			return;
		}

		if(Storage::disk('local')->exists($this->temp_path))
		{
			Storage::disk('do_space')->putFileAs($this->photo->album->slug, Storage::disk('local')->path($this->temp_path), $this->slug, 'public');
			Storage::disk('local')->delete($this->temp_path);

			$this->photo->temp_path = null;
			$this->photo->save();
		}
    }
}
