<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'purchase_id' => $this->purchase_id,
            'hsn' => $this->hsn,
            'unit_price' => $this->unit_price,
            'gst_percent' => $this->gst_percent,
            'p_quantity' => $this->product->quantity,
            'quantity' => $this->quantity,
            'mfg_date' => $this->mfg_date,
            'expiry_date' => $this->expiry_date,
            'selling_price' => $this->selling_price,
        ];
    }
}
