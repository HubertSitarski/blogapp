<?php

namespace App\Services\Api;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class FractalService
{
    private Manager $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function getTransformedItem(Model $model, TransformerAbstract $transformer): ?array
    {
        $item = new Item($model, $transformer);

        return $this->fractal->createData($item)->toArray();
    }
}
