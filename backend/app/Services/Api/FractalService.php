<?php

namespace App\Services\Api;

use Illuminate\Support\Collection as IlluminateCollection;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class FractalService
{
    public function __construct(private Manager $fractal)
    {
    }

    public function getTransformedItem(
        Model $model,
        TransformerAbstract $transformer,
        array $includes = []
    ): ?array {
        $item = new Item($model, $transformer);

        $this->fractal->parseIncludes($includes);

        return $this->fractal->createData($item)->toArray();
    }

    public function getTransformedCollection(
        IlluminateCollection $illuminateCollection,
        TransformerAbstract $transformer,
        array $includes = []
    ): ?array {
        $collection = new Collection($illuminateCollection, $transformer);

        $this->fractal->parseIncludes($includes);

        return $this->fractal->createData($collection)->toArray();
    }
}
