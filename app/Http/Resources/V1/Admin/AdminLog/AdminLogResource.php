<?php

namespace App\Http\Resources\V1\Admin\AdminLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'role' => $this->admin?->role_id == 1 ? 'Admin' : 'User',
            'name' => $this->admin?->first_name .' '. $this->admin?->middle_name .' '. $this->admin?->last_name,
            'action' => $this->action,
            'description' => $this->description
        ];
    }
}
