<?php

namespace Sevming\LaravelApiResource;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    use FilterField;

    /**
     * @param mixed $resource
     *
     * @return BaseResourceCollection
     */
    public static function collection($resource)
    {
        if ((Str::endsWith(class_basename(static::class), 'Resource')
            && class_exists($class = Str::replaceLast('Resource', 'Collection', static::class)))
            || class_exists($class = (static::class . 'Collection'))
            ) {
            return new $class($resource);
        }

        return tap(new AnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }
}