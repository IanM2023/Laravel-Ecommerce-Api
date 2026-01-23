<?php

namespace App\Http\Controllers\V1\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Address\StoreAddressRequest;
use App\Http\Requests\V1\Address\UpdateAddressRequest;
use App\Http\Resources\V1\Address\AddressResource;
use App\Models\Address;
use App\Models\Notification;
use App\Traits\NotificationMessagesTrait;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    use NotificationMessagesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $address = Address::where('user_id', auth()->user()->id)->get();

        if($address->isEmpty()) {
            return response()->json(['message' => 'No address found'], 404);
        }

        return response()->json([
            'message' => 'Fetch User Address successfully',
            'data'    => AddressResource::collection($address)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $address = $request->validated();
        $userID = auth()->user()->id;

        $data = Address::create([
            'user_id'               => $userID,
            'type'                  => $address['type'],
            'region_code'           => $address['region_code'],
            'region_details'        => $address['region_details'],
            'province_code'         => $address['province_code'],
            'province_details'      => $address['province_details'],
            'city_munic_code'       => $address['city_munic_code'],
            'city_munic_details'    => $address['city_munic_details'],
            'brgy_code'             => $address['brgy_code'],
            'brgy_details'          => $address['brgy_details'],
            'detailed_address'      => $address['detailed_address'],
            'is_default'            => 0,
        ]);

        $message = $this->addressCreatedMessage();

        Notification::insertNotification($userID, 
            $message['type'], 
            $data->id, 
            $message['details']
        );

        return response()->json([
            'message' => 'User Address successfully saved',
            'data'    => new AddressResource($data)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = Address::findOrFail($id);
        return response()->json([
            'message' => 'User Address successfully saved',
            'data' => new AddressResource($address)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $data = $request->validated();
    
        // Optional: enforce ownership
        $data['user_id'] = auth()->id();
    
        $address->update($data);

        $message = $this->addressUpdatedMessage();

        Notification::insertNotification(auth()->id(), 
            $message['type'], 
            $address->id, 
            $message['details']
        );
    
        return response()->json([
            'message' => 'User address updated successfully',
            'data' => $address->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        $message = $this->addressDeletedMessage();

        Notification::insertNotification(auth()->id(), 
            $message['type'], 
            $address->id, 
            $message['details']
        );

        return response()->json([
            'message' => 'User address deleted successfully',
        ], 200);
    }

    public function setDefault($id)
    {
        $userId = auth()->id();
    
        // 1. Get the address & ensure ownership
        $address = Address::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    
        // 2. If already default → early return
        if ($address->is_default) {
            return response()->json([
                'message' => 'This address is already set as default',
            ], 200);
        }
    
        // 3. Remove default from other addresses
        Address::where('user_id', $userId)
            ->where('is_default', true)
            ->update(['is_default' => false]);
    
        // 4. Set selected address as default
        $address->update(['is_default' => true]);
    
        return response()->json([
            'message' => 'Default address updated successfully',
        ], 200);
    }
    
}
