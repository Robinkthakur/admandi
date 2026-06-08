<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->basePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->basePath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->basePath($media) . '/responsive-images/';
    }

    protected function basePath(Media $media): string
    {
        $model = strtolower(class_basename($media->model_type));

        $id = $media->model_id;

        $group = floor($id / 1000) * 1000;

        return "{$model}s/{$group}/{$id}";
    }
}