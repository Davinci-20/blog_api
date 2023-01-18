<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'created_at_readable'=>Carbon::parse($this->created_at)->diffForHumans(),
            'title'=>$this->title,
            'description'=>Str::limit($this->description, 30),
            'image'=>$this->image ? asset('storage/media/'.$this->image->file_name) : null,
            
        ];
    }
}