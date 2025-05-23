<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Application $app;
    protected Model $model;

    abstract public function model(): string;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function update(array $input, $id)
    {
        $model = $this->find($id);
        if ($model) {
            $model->fill($input)->save();
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }
}
