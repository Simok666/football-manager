<?php

namespace App\Http\Resources;

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
        // dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nik' => $this->nik,
            'place_of_birth' => $this->place_of_birth,
            'birth_of_date' => $this->birth_of_date,
            'address' => $this->address,
            'school' => $this->school,
            'class' => $this->class,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'parents_contact' => $this->parents_contact,
            'weight' => $this->weight,
            'height' => $this->height,
            'id_positions' => $this->id_positions,
            'id_contributions' => $this->id_contributions,
            'position' => new PositionResource($this->whenLoaded('position')) ,
            'history' => $this->history,
            'contribution' => new ContributionResource($this->whenLoaded('contribution')),
            'status' => new StatusResource($this->whenLoaded('status')),
            'strength' => $this->strength,
            'weakness' => $this->weakness,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
