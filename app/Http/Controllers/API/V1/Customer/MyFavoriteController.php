<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Models\MyFavorite;
use App\Models\BarberRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\Customer\MyFavoriteResource;

class MyFavoriteController extends Controller
{
    //

    public function getAllMyFavorites(Request $request)
    {
        try {


            $id = Auth::user()->id;
            $data = MyFavorite::with("barber")->where('user_id', $id);
            $total = $data->count();
            $datas = $data->paginate(10);

            foreach ($datas as $data) {
                $rating = BarberRating::where('barber_id', $data->barber_id)->avg('rating');
                $data->average_rating = $rating ? number_format($rating, 1) : "0"; // Add average rating to each item
            }

            $result = MyFavoriteResource::collection($datas);
            if($result) {
            return response()->json(
                [
                    'data' => $result,
                    'total' => $total,
                    'message' => __('message.My favorite list get successfully.'),
                    'status' => 1,
                ]
                , 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function addAndRemoveFavorite(Request $request)
    {

        $language_code = $request->header('language');
        $validated['barber_id'] = "required";

        $customMessages = [
            'barber_id.required' => __('error.The barber id field is required'),
        ];

        $request->validate($validated, $customMessages);
        try {

            $user_id = Auth::user()->id;
            $check_favorite_list = MyFavorite::where('barber_id', $request->barber_id)->where('user_id', $user_id)->first();
            if (empty($check_favorite_list)) {

                $data = new MyFavorite();
                $data->user_id = $user_id;
                $data->barber_id = $request->barber_id;
                $data->save();
                $message = __('message.Barber added successfully to favourite list.');
                $is_favorite = 1;
            } else {
                $is_favorite = 0;
                $check_favorite_list->delete();
                $message = __('message.Barber remove successfully to favourite list.');

            }

            return response()->json(
                [
                    'is_favorite' => $is_favorite,
                    'status' => 1,
                    'message' => $message,
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

}
