<?php

namespace App\Http\Controllers\Front;

use App\Models\Pagies;
use App\Models\MyFavorite;
use App\Models\BarberRating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

    public function myFavoriteList()
    {
        $user_id = Auth::user()->id;
        $favorites = MyFavorite::with('barber')->where('user_id', $user_id)->paginate(4);

        foreach ($favorites as $favorite) {
            $rating = BarberRating::where('barber_id', $favorite->barber->id)->avg('rating');
            $favorite['barber']['rating'] = $rating ? number_format($rating, 1) : "0"; // Add average rating to each item
            $favorite['barber']['encrypt_id'] = Crypt::encryptString($favorite->barber->id);
        }


        $data = Pagies::with("meta_content", "cms_content")->find(10);
        return view('Frontend.Auth.my-favorite', compact('data','favorites'));
    }

}
