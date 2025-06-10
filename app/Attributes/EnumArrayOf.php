<?php

namespace App\Attributes;

use Attribute;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptTransformableAttribute;
use Spatie\TypeScriptTransformer\Types\StructType;

#[Attribute]
class EnumArrayOf implements TypeScriptTransformableAttribute
{
    public function __construct(
        protected string $enum,
    ) {}

    public function getType(): Type
    {
        return new Array_(StructType::fromArray([
            'value' => $this->enum,
            'label' => 'string',
        ]));
    }
}
