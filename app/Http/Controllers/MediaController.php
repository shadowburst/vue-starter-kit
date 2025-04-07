<?php

namespace App\Http\Controllers;

use App\Data\Media\MediaResource;
use App\Data\Media\StoreMediaRequest;
use App\Services\MediaService;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService,
    ) {}

    public function store(StoreMediaRequest $data)
    {
        try {
            $media = $this->mediaService->store->execute($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(MediaResource::from($media));
    }
}
