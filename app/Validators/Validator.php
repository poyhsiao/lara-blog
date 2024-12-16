<?php

namespace App\Validators;

use Illuminate\Database\Eloquent\Model;

abstract class Validator
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
