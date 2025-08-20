<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $processed_at
 * @property Carbon $created_at
 * @property array $data
 */
class LeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->processed_at ? 'processed' : 'new',
            'created_at' => $this->created_at->toDateTimeString(),
            'client' => [
                'name' => $this->data['first_name'] . ' ' . $this->data['last_name'],
                'phone' => $this->data['phone'],
            ],
            'application' => [
                'amount' => $this->data['amount'],
                'term' => $this->data['term'],
            ],
        ];
    }
}
