<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $quarded = [];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function path(): Attribute
    {
        return Attribute::set(function (array $pathData) {
            /**
             * @var \Illuminate\Http\UploadedFile $file
             */
            $file = $pathData['image'];
            $fileName = Str::slug(microtime());
            $filePath = $pathData['path'] . $fileName . $file->getClientOriginalName();

            Storage::put($filePath, File::get($file));
            Storage::setVisibility($filePath, 'public');

            return $filePath;
        });
    }
}
