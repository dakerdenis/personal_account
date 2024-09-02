<?php

namespace App\Repository;

interface FileRepositoryInterface
{
    public function format(object $image, array $dimensions, string $path): mixed;
}
