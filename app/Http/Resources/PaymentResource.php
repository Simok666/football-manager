<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'status' => $this->status,
            'payment_confirmation' => $this->payment_confirmation,
            'proof_payment' => $this->proof_payment,
            'date_payment' => $this->date_payment
        ];
    }
}
