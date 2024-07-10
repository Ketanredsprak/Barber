<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MyFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MyFavoriteController extends Controller
{
    //

    public function addAndRemoveFavorite($id)
    {
        $user_id = Auth::user()->id;
        $check_favorite_list = MyFavorite::where('barber_id', $id)->where('user_id', $user_id)->first();
        if (empty($check_favorite_list)) {

            $data = new MyFavorite();
            $data->user_id = $user_id;
            $data->barber_id = $id;
            $data->save();
            $message = __('message.Barber added successfully to favourite list.');
        } else {
            $check_favorite_list->delete();
            $message = __('message.Barber remove successfully to favourite list.');

        }
        return Redirect::back()->with('message', $message);

    }
}
