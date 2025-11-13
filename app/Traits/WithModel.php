<?php

namespace App\Traits;

/**
 * @template T
 */
trait WithModel
{
    /** @var T|null */
    protected $model;

    public static function bootWithModel(): void {}

    public function initializeWithModel(): void {}

    /**
     * @return class-string<T>|null
     *
     * @throws \Exception
     */
    protected function getModelClass(): string
    {
        $modelClass = match (true) {
            property_exists($this, 'modelClass') => $this->modelClass,
            method_exists($this, 'modelClass')   => $this->modelClass(),
            default                              => null,
        };

        if (! is_a($modelClass, \Illuminate\Database\Eloquent\Model::class, true)) {
            throw new \Exception('Invalid model class: '.$modelClass);
        }

        return $modelClass;
    }

    /**
     * @return T
     */
    public function getModel()
    {
        return $this->model ??= $this->getModelClass()::find($this->id);
    }
}
