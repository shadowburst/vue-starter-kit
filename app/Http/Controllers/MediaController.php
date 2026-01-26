<?php

namespace App\Http\Controllers;

use App\Actions\Media\CreateMedia;
use App\Data\Media\MediaData;
use App\Data\Media\MediaFormRequest;
use App\Models\Media;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class MediaController extends Controller
{
    public function show(Media $media, Request $request)
    {
        Gate::authorize('view', $media);

        return $media->toInlineResponse($request);
    }

    public function store(MediaFormRequest $data)
    {
        Gate::authorize('create', Media::class);

        try {
            $media = app(CreateMedia::class)->execute($data, Auth::user());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(MediaData::from($media));
    }
}
