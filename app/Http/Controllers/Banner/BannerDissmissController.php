<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

class BannerDissmissController extends Controller
{
    public function update(Banner $banner)
    {
        Auth::user()->banners()->syncWithoutDetaching([$banner->id]);

        return back();
    }
}
