<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "ISBN"=> $this->ISBN,
            "author"=>$this->author,
            "publisher"=>$this->publisher,
            "publish_date"=>$this->publish_date,
            "category"=>CtegoryResource::make($this->whenLoaded("category")),
            "is_available" => !$this->customers()->wherePivot("is_returned", false)->exists(),
        ];
    }
}
