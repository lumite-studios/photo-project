<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FixUnsorted extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$albums = Album::where('editable', '=', false)->get();

		foreach($albums as $album)
		{
			$album->slug = Str::slug($album->name);
			$album->save();
		}
    }
}
