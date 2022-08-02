<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

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
        $data = parent::toArray($request);

        Log::info($data);
        
        $user_id = null;
        if (isset($data[0]['user_id']))
        {
            $user_id = $data[0]['user_id'];
        }
        else {
            $user_id = $data['user_id'];
        }


        return [
            ...$data,
            "user_name" => User::findOrFail($user_id)->name         
        ];
        
    }
}
