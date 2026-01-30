<?php

namespace App\Http\Resources\V1\User\Auth;

use App\Http\Resources\V1\User\Address\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $prefix = $this->prefix ? $this->prefix . ' ' : '';

        $fullName = trim(collect([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ])->filter()->implode(' '));
        
        $status = $this->status == 0 ? 'active' : 'inactive';
        
        return [
            'id'        => $this->id,
            'full_name' => $prefix . $fullName,
            'email'     => $this->email,
            'gender'    => $this->gender,
            'status'    => $status,
            'address'   => AddressResource::collection($this->whenLoaded('addresses')),
            'create_at' => $this->created_at->format('D-M-Y H:i:s A'),
            'updated_at'=> $this->updated_at->format('D-M-Y H:i:s A'),
        ];
        
    }
}
