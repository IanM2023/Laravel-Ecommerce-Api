<?php

namespace App\Services\V1\Admin;

use App\Models\AdminLog;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    protected AdminLoggerService $adminLogger;

    public function __construct(AdminLoggerService $adminLogger)
    {
        $this->adminLogger = $adminLogger;
    }

    public function storeProductImage(array $data)
    {
        return DB::transaction(function () use ($data) {

            $variantId = $data['variant_id'];
            $productId = $data['product_id'];
            $files      = $data['paths'];
            $isPrimary = (int) $data['is_primary'] ?? 0;

            if($isPrimary === 1) {
                ProductImage::where('variant_id', $variantId)
                    ->update(['is_primary' => 0]);
            }

        
            $createdImages = [];
            
            foreach ($files as  $file) {
                $path = $file->store('product_images', 'public'); // saves to storage/app/public/product_images
        
                $images = ProductImage::create([
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'path' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $createdImages[] = $images;

                $this->adminLogger->log(
                    'Store',
                    $images,
                    'Uploaded product image(s)'
                );
            }
        
            return $createdImages;

        });
    }

    public function updateProductImage(ProductImage $productImage, array $data)
    {
        return DB::transaction(function () use ($productImage, $data) {
    
            $isPrimary = (int) $data['is_primary'];
    
            // Only reset others if this image becomes primary
            if ($isPrimary === 1 && $productImage->is_primary !== 1) {
                ProductImage::where('variant_id', $productImage->variant_id)
                    ->where('id', '!=', $productImage->id)
                    ->update(['is_primary' => 0]);
            }
    
            // Replace file only if a new one is uploaded
            if (!empty($data['path'])) {
    
                // Delete old file
                if ($productImage->path && Storage::disk('public')->exists($productImage->path)) {
                    Storage::disk('public')->delete($productImage->path);
                }
    
                // Store new file
                $newPath = $data['path']->store('product_images', 'public');
    
                $productImage->path = $newPath;
            }
    
            // Update primary flag
            $productImage->is_primary = $isPrimary;
            $productImage->save();

            $this->adminLogger->log(
                'Update',
                $productImage,
                'Updated product image(s)'
            );
    
            return $productImage;
        });
    }
    
    public function deleteProductImage(ProductImage $productImage)
    {
        return  DB::transaction(function () use ($productImage) {
    
            $variantId = $productImage->variant_id;
            $wasPrimary = $productImage->is_primary;

            $productImage->update([
                'is_primary' => 0,
            ]);
    
            // Soft delete the image
            $productImage->delete();
    
            // If deleted image was primary, promote another one
            if ($wasPrimary) {
                $nextImage = ProductImage::where('variant_id', $variantId)
                    ->whereNull('deleted_at')
                    ->orderBy('id') // or created_at
                    ->first();
    
                if ($nextImage) {
                    $nextImage->update(['is_primary' => 1]);
                }
            }
            
            $this->adminLogger->log(
                'Delete',
                $productImage,
                'Deleted product image(s)'
            );
        });
    }
}