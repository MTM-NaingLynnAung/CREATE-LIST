<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $children = $this->whenLoaded('children');
        return [

            'name' => $this->when(method_exists($children, 'isEmpty') && !$children->isEmpty(), $this->name),
            'category' => $this->when(method_exists($children, 'isEmpty') && !$children->isEmpty(), ChildrenResource::collection($children))
        ];
    }
}
