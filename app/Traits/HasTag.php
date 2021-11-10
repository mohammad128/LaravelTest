<?php
namespace App\Traits;

use App\Models\Tag;

trait HasTag {


    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function removeAllTags() {

    }
}
