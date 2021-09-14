<?php

namespace Sevming\LaravelApiResource;

trait FilterField
{
    protected string $scene = 'default';

    protected array $showFields = [];

    protected array $hideFields = [];

    public function scene(string $scene): self
    {
        $this->scene = $scene;
        return $this;
    }

    public function show(array $fields): self
    {
        $this->showFields = array_merge($this->showFields, $fields);
        return $this;
    }

    public function hide(array $fields): self
    {
        $this->hideFields = array_merge($this->hideFields, $fields);;
        return $this;
    }

    public function filterFields($data): array
    {
        if (!empty($this->showFields)) {
            return collect($data)->only($this->showFields)->toArray();
        }

        return collect($data)->except($this->hideFields)->toArray();
    }
}