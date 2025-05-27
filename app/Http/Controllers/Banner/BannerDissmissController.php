<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class BannerDissmissController extends Controller
{
    public function update(#[CurrentUser] User $user, Banner $banner)
    {
        $user->banners()->syncWithoutDetaching([$banner->id]);

        return back();
    }
}
