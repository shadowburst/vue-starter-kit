<?php

namespace App\Attributes;

use Attribute;
use phpDocumentor\Reflection\Type;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptTransformableAttribute;
use Spatie\TypeScriptTransformer\Types\RecordType;
use Spatie\TypeScriptTransformer\Types\TypeScriptType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ModelPolicy implements TypeScriptTransformableAttribute
{
    public function __construct(
        protected string $model,
    ) {}

    public function getType(): Type
    {
        $model = app($this->model);

        if (! method_exists($model, 'getPolicies')) {
            return new RecordType('string', 'boolean');
        }

        $keys = collect($model->getPolicies())
            ->map(fn (string $permission) => "'$permission'")
            ->join(' | ');

        return new TypeScriptType("Record<$keys, boolean>");
    }
}
