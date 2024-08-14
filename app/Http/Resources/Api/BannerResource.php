<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language =  $request->header('language') ?? "en";
        $title = "title_". $language;
        $content = "content_". $language;

        return [
            'id' => $this->id,
            'barber_id' => $this->barber_id,
            'title' => $this->$title,
            'content' => $this->$content,
            'banner_image' => URL::to('/public') . '/banner_image/' .$this->banner_image ?? "",
            'created_at' =>  date('Y-M-d h:i A', strtotime($this->created_at)),
        ];

    }
}
