<?php

namespace App\Data\Media;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class MediaFormRequest extends Data
{
    public function __construct(
        #[FromRouteParameter('modelType')]
        public string $model_type,

        #[FromRouteParameter('modelId')]
        public int $model_id,

        #[FromRouteParameter('collection')]
        public string $collection,

        #[LiteralTypeScriptType('File')]
        public UploadedFile $file,
    ) {}

    public static function attributes(): array
    {
        return [
            'file' => __('file'),
        ];
    }

    public static function rules(ValidationContext $context): array
    {
        $modelClass = Relation::getMorphedModel($context->payload['model_type']);
        abort_if(! $modelClass, Response::HTTP_NOT_FOUND);

        /** @var \Illuminate\Database\Eloquent\Model&\Spatie\MediaLibrary\HasMedia $model */
        $model = app($modelClass)->findOrFail($context->payload['model_id']);

        /** @var ?\Spatie\MediaLibrary\MediaCollections\MediaCollection $collection */
        $collection = method_exists($model, 'getMediaCollection') ? $model->getMediaCollection($context->payload['collection']) : null;
        abort_if(! $collection, Response::HTTP_NOT_FOUND);

        $mimeTypes = implode(',', $collection->acceptsMimeTypes);
        $max = 5;
        if (str_contains($mimeTypes, 'image/')) {
            $max = 10;
        }
        if (str_contains($mimeTypes, 'video/')) {
            $max = 100;
        }
        $max *= 1024; // Value in MB

        return [
            'file' => [$mimeTypes ? "mimetypes:{$mimeTypes}" : '', "max:{$max}"],
        ];
    }
}
