<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Arr::forget($this->resource, 'user');
        return [
            'contact_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthday' => $this->birthday->format('m/d/Y'),
            'company' => $this->company,
            'last_updated' => $this->updated_at->diffForHumans(),
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => $this->path(),
            ],
        ];
    }
}
