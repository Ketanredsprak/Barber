<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AppConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $languege = $request->header('language');
        $customerAppTitleField = 'customer_app_title_' . $languege;
        $customerAppContentField = 'customer_app_content_' . $languege;
        $barberAppTitleField = 'barber_app_title_' . $languege;
        $barberAppContentField = 'barber_app_content_' . $languege;

        return [
            'id' => $this->id,
            'customer_app_login_image' => URL::to('/public/website-config/' . ($this->customer_app_login_image ?: 'no-image.png')),
            'barber_app_login_image' => URL::to('/public/website-config/' . ($this->barber_app_login_image ?: 'no-image.png')),
            'customer_app_title' => $this->$customerAppTitleField,
            'customer_app_content' => $this->$customerAppContentField,
            'barber_app_title' => $this->$barberAppTitleField,
            'barber_app_content' => $this->$barberAppContentField,

        ];
    }
}
