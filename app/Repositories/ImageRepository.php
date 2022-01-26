<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function create(array $data)
    {
        return $this->image->create($data);
    }
}
