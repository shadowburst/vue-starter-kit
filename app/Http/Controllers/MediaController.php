<?php

namespace App\Http\Controllers;

use App\Data\Media\MediaFormRequest;
use App\Data\Media\MediaResource;
use App\Services\MediaService;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService,
    ) {}

    public function store(MediaFormRequest $data)
    {
        try {
            $media = $this->mediaService->create->execute($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(MediaResource::from($media));
    }
}
