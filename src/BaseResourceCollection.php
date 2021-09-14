<?php

namespace Sevming\LaravelApiResource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    use FilterField;

    public function toArray($request)
    {
        return $this->collection->map(function ($item) use ($request) {
            $item->scene($this->scene)->show($this->showFields)->hide($this->hideFields);
            return \array_merge_recursive($item->toArray($request), $item->with($request), $item->additional);
        });
    }
}