<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'user_id'=>optional($this->user)->name ?? 'Unknow UserName','category_id'=>optional($this->category)->name ?? 'Unknow Category',
            'created_at'=>Carbon::parse($this->created_at)->format('Y-m-d h:i:s A'),
            'created_at_readable'=>\Illuminate\Support\Carbon::parse($this->created_at)->diffForHumans(),
            'title'=>$this->title,
            'description'=>$this->description,
            'image'=>$this->image ? asset('storage/media/'.$this->image->file_name) : null,
            
        ];
    }
}