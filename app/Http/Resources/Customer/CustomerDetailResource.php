<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Country\CountryResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string|null $company_name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $address_1
 * @property string|null $address_2
 * @property string $zip
 * @property Model $country
 * @property string $city
 * @property string $phone
 * @property string|null $notes
 */
class CustomerDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company_name' => $this->company_name,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'zip' => $this->zip,
            'country' => new CountryResource($this->country),
            'city' => $this->city,
            'phone' => $this->phone,
            'notes' => $this->notes,
        ];
    }
}
