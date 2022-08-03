<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->collection;
        $user_id = $data[0]['user_id'];
        return [
            "data" => $data,
            "user_name" => User::findOrFail($user_id)->name,  
        ];
    }
}
