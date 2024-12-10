<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->role;
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $role ?? "",
            'token' => $this->createToken('mobile', ['role:'. $role])->plainTextToken
        ];
    }
}
