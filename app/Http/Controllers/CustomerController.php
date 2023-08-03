<?php

namespace App\Http\Controllers;

use App\Facades\CustomerDetailFacade;
use App\Facades\CustomerFacade;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * @return CustomerResource
     */
    public function profile(): CustomerResource
    {
        $item = CustomerFacade::findByEmail(auth()->user()->email);
        return new CustomerResource($item);
    }

    /**
     * @param UpdateProfileRequest $request
     * @return CustomerResource
     */
    public function update(UpdateProfileRequest $request): CustomerResource
    {
        $data = $request->validated();
        $customerId = null;
        if (auth()->user()) {
            $customerId = auth()->user()->id;
        }

        $updated = CustomerFacade::updateDetails($customerId, $data);
        return new CustomerResource($updated);
    }
}
