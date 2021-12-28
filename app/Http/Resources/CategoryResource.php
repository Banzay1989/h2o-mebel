<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uid' => $this->parent_id ? $this->parent_id.'_'.$this->id : $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' =>$this->updated_at,
            'parent_id' => $this->parent_id,
            'children' => self::collection($this->children),
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }
}
