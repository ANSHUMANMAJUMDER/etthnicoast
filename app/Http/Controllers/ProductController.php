<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\PolishType;
use App\Models\StoneType;
use App\Models\PearlType;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductCodeItemDetail;
use App\Models\ProductCodeEmblishments;
use App\Models\ProductCodeFinishing;
use App\Models\ProductCodeMakers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductSimilarItem;
use App\Models\ProductCompleteLook;
DB::enableQueryLog();

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $filters = [
            'category_id' => $request->category_id,
            'polish_type_id' => $request->polish_type_id,
            'stone_type_id' => $request->stone_type_id,
            'pearl_type_id' => $request->pearl_type_id,
        ];

        $products = Product::with([
                'category','polish','stone','pearl',
                'images',
               'variants.images'
            ])
            ->when($q, function ($query) use ($q) {
                $query->where('product_code', 'like', "%{$q}%")
                      ->orWhere('base_name', 'like', "%{$q}%");
            })
            ->when($filters['category_id'], fn($qr) => $qr->where('category_id', $filters['category_id']))
            ->when($filters['polish_type_id'], fn($qr) => $qr->where('polish_type_id', $filters['polish_type_id']))
            ->when($filters['stone_type_id'], fn($qr) => $qr->where('stone_type_id', $filters['stone_type_id']))
            ->when($filters['pearl_type_id'], fn($qr) => $qr->where('pearl_type_id', $filters['pearl_type_id']))
            ->latest()
            ->paginate(10)
            ->withQueryString();
// dd($products);
        $categories = Category::orderBy('category_name')->get();
        $polishTypes = PolishType::where('is_active', 1)->orderBy('display_order')->get();
        $stoneTypes  = StoneType::where('is_active', 1)->orderBy('display_order')->get();
        $pearlTypes  = PearlType::where('is_active', 1)->orderBy('display_order')->get();


        // ✅ NEW PREFIX DATA
    $itemPrefixes = ProductCodeItemDetail::orderBy('item_name')->get();
    $emblishments = ProductCodeEmblishments::orderBy('emblishment_name')->get();
    $finishings   = ProductCodeFinishing::orderBy('finishing_name')->get();
    $makers       = ProductCodeMakers::orderBy('makers_name')->get();

$allProducts = Product::with('images:id,product_id,image')
    ->select('id', 'product_code', 'base_name', 'base_price')
    ->where('is_active', 1)
    ->orderBy('base_name')
    ->get();
        return view('products.index', compact(
            'products','q','filters','categories','polishTypes','stoneTypes','pearlTypes',
            'itemPrefixes','emblishments','finishings','makers','allProducts'
        ));
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'product_code' => 'nullable|string|max:255|unique:products,product_code',
            'base_name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'quantity' => 'nullable|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cgst' => 'nullable|numeric|min:0',
            'sgst' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',

            'stone_type_id' => 'nullable|exists:stone_types,id',
            'pearl_type_id' => 'nullable|exists:pearl_types,id',
            'polish_type_id' => 'nullable|exists:polish_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        // $productCode = $request->product_code ?: $this->generateUniqueCode('PRD', 'products', 'product_code');
        $prefix = $request->item_prefix . '-' .
          $request->emb_prefix . '-' .
          $request->fin_prefix . '-' .
          $request->maker_prefix;

$productCode = $request->product_code 
    ?: $this->generateUniqueCodeProduct($prefix, 'products', 'product_code');

        $product = Product::create([
            'product_code' => $productCode,
            'base_name' => $request->base_name,
            'description' => $request->description,

            'quantity' => $request->quantity ?? 0,
            'base_price' => $request->base_price ?? 0,
            'discount_price' => $request->discount_price,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
            'weight' => $request->weight,

            'stone_type_id' => $request->stone_type_id,
            'pearl_type_id' => $request->pearl_type_id,
            'polish_type_id' => $request->polish_type_id,
            'category_id' => $request->category_id,

            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // upload product images (multiple)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'variant_id' => null,
                    'type' => 'product',
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    private function generateUniqueCodeProduct($prefix, $table, $column)
{
    $lastCode = DB::table($table)
        ->where($column, 'like', $prefix . '-%')
        ->orderByDesc($column)
        ->value($column);

    if ($lastCode) {
        $lastNumber = (int) substr($lastCode, strrpos($lastCode, '-') + 1);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '001';
    }

    return $prefix . '-' . $newNumber;
}
    // public function update(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
    //         'base_name' => 'required|string|max:255',
    //         'description' => 'nullable|string',

    //         'quantity' => 'nullable|numeric|min:0',
    //         'base_price' => 'required|numeric|min:0',
    //         'discount_price' => 'nullable|numeric|min:0',
    //         'cgst' => 'nullable|numeric|min:0',
    //         'sgst' => 'nullable|numeric|min:0',
    //         'weight' => 'nullable|numeric|min:0',

    //         'stone_type_id' => 'nullable|exists:stone_types,id',
    //         'pearl_type_id' => 'nullable|exists:pearl_types,id',
    //         'polish_type_id' => 'nullable|exists:polish_types,id',
    //         'category_id' => 'nullable|exists:categories,id',
    //         'is_active' => 'nullable',

    //         'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
    //     ]);

    //     $product->update([
           
    //         'base_name' => $request->base_name,
    //         'description' => $request->description,

    //         'quantity' => $request->quantity ?? 0,
    //         'base_price' => $request->base_price ?? 0,
    //         'discount_price' => $request->discount_price,
    //         'cgst' => $request->cgst,
    //         'sgst' => $request->sgst,
    //         'weight' => $request->weight,

    //         'stone_type_id' => $request->stone_type_id,
    //         'pearl_type_id' => $request->pearl_type_id,
    //         'polish_type_id' => $request->polish_type_id,
    //         'category_id' => $request->category_id,

    //         'is_active' => $request->has('is_active') ? 1 : 0,
    //     ]);

    //     // append more images
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $img) {
    //             $path = $img->store('products', 'public');
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'variant_id' => null,
    //                 'type' => 'product',
    //                 'image' => $path,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // }

 

public function update(Request $request, Product $product)
{
    $request->validate([
        'product_code' => [
            'nullable',
            'string',
            'max:255',
            Rule::unique('products', 'product_code')->ignore($product->id),
        ],
        'base_name' => 'required|string|max:255',
        'description' => 'nullable|string',

        'quantity' => 'nullable|numeric|min:0',
        'base_price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0',
        'cgst' => 'nullable|numeric|min:0',
        'sgst' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',

        'stone_type_id' => 'nullable|exists:stone_types,id',
        'pearl_type_id' => 'nullable|exists:pearl_types,id',
        'polish_type_id' => 'nullable|exists:polish_types,id',
        'category_id' => 'nullable|exists:categories,id',

        'is_active' => 'nullable',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
    ]);

  
    $prefix = $request->item_prefix && $request->emb_prefix
        ? $request->item_prefix . '-' .
          $request->emb_prefix . '-' .
          $request->fin_prefix . '-' .
          $request->maker_prefix
        : null;

    if (!$request->product_code && $prefix) {
        // Regenerate if empty
        $productCode = $this->generateUniqueCode($prefix, 'products', 'product_code');
    } else {
        $productCode = $request->product_code ?? $product->product_code;
    }


    $product->update([
        'product_code' => $productCode,
        'base_name' => $request->base_name,
        'description' => $request->description,

        'quantity' => $request->quantity ?? 0,
        'base_price' => $request->base_price ?? 0,
        'discount_price' => $request->discount_price,
        'cgst' => $request->cgst,
        'sgst' => $request->sgst,
        'weight' => $request->weight,

        'stone_type_id' => $request->stone_type_id,
        'pearl_type_id' => $request->pearl_type_id,
        'polish_type_id' => $request->polish_type_id,
        'category_id' => $request->category_id,

        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Append More Images
    |--------------------------------------------------------------------------
    */

    // if ($request->hasFile('images')) {
    //     foreach ($request->file('images') as $img) {
    //         $path = $img->store('products', 'public');

    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'variant_id' => null,
    //             'type' => 'product',
    //             'image' => $path,
    //         ]);
    //     }
    // }
    if ($request->hasFile('images')) {
    // Delete old images
    $oldImages = ProductImage::where('product_id', $product->id)
        ->where('type', 'product')
        ->get();

    foreach ($oldImages as $oldImage) {
        if (Storage::disk('public')->exists($oldImage->image)) {
            Storage::disk('public')->delete($oldImage->image);
        }
        $oldImage->delete();
    }

    // Store new images
    foreach ($request->file('images') as $img) {
        $path = $img->store('products', 'public');

        ProductImage::create([
            'product_id' => $product->id,
            'variant_id' => null,
            'type'       => 'product',
            'image'      => $path,
        ]);
    }
}

    return redirect()
        ->route('products.index')
        ->with('success', 'Product updated successfully.');
}
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    // ================== VARIANTS ==================

    // public function storeVariant(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'product_code' => 'nullable|string|max:255|unique:product_variants,product_code',

    //         'polish_type_id' => 'nullable|exists:polish_types,id',
    //         'stone_type_id' => 'nullable|exists:stone_types,id',
    //         'pearl_type_id' => 'nullable|exists:pearl_types,id',

    //         'quantity' => 'nullable|numeric|min:0',
    //         'base_price' => 'required|numeric|min:0',
    //         'discount_price' => 'nullable|numeric|min:0',
    //         'cgst' => 'nullable|numeric|min:0',
    //         'sgst' => 'nullable|numeric|min:0',
    //         'weight' => 'nullable|numeric|min:0',

    //         'variant_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
    //     ]);

    //     $variantCode = $request->product_code ?: $this->generateUniqueCode('VRN', 'product_variants', 'product_code');

    //     $variant = ProductVariant::create([
    //         'product_id' => $product->id,
    //         'product_code' => $variantCode,

    //         'polish_type_id' => $request->polish_type_id,
    //         'stone_type_id' => $request->stone_type_id,
    //         'pearl_type_id' => $request->pearl_type_id,

    //         'quantity' => $request->quantity ?? 0,
    //         'base_price' => $request->base_price ?? 0,
    //         'discount_price' => $request->discount_price,
    //         'cgst' => $request->cgst,
    //         'sgst' => $request->sgst,
    //         'weight' => $request->weight,
    //     ]);

    //     // upload variant images (multiple)
    //     if ($request->hasFile('variant_images')) {
    //         foreach ($request->file('variant_images') as $img) {
    //             $path = $img->store('products/variants', 'public');
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'variant_id' => $variant->id,
    //                 'type' => 'product_variant',
    //                 'image' => $path,
    //             ]);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Variant added successfully.');
    // }
public function storeVariant(Request $request, Product $product)
{
    try {
     
        Log::info('Variant store called', [
            'product_id' => $product->id,
            'request' => $request->except(['variant_images']),
            'has_files' => $request->hasFile('variant_images'),
        ]);

        $request->validate([
            'product_code' => 'nullable|string|max:255',
            'polish_type_id' => 'nullable|exists:polish_types,id',
            'stone_type_id' => 'nullable|exists:stone_types,id',
            'pearl_type_id' => 'nullable|exists:pearl_types,id',
            'quantity' => 'nullable|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cgst' => 'nullable|numeric|min:0',
            'sgst' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'variant_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $variantCode = $request->product_code ?: $this->generateUniqueCode('VRN', 'product_variants', 'product_code');

        \Log::info('Generated variant code', ['variant_code' => $variantCode]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'product_code' => $variantCode,
            'polish_type_id' => $request->polish_type_id,
            'stone_type_id' => $request->stone_type_id,
            'pearl_type_id' => $request->pearl_type_id,
            'quantity' => $request->quantity ?? 0,
            'base_price' => $request->base_price ?? 0,
            'discount_price' => $request->discount_price,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
            'weight' => $request->weight,
        ]);

        \Log::info('Variant created', ['variant_id' => $variant->id]);

        if ($request->hasFile('variant_images')) {
            foreach ($request->file('variant_images') as $img) {
                $path = $img->store('products/variants', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'variant_id' => $variant->id,
                    'type' => 'product_variant',
                    'image' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Variant added successfully.');
    } catch (\Throwable $e) {
        Log::error('Variant store failed', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return redirect()->back()->with('error', 'Variant store failed: '.$e->getMessage());
    }
}

public function updateVariant(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'product_code' => 'required|string|max:255|unique:product_variants,product_code,' . $variant->id,
            'polish_type_id' => 'nullable|exists:polish_types,id',
            'stone_type_id' => 'nullable|exists:stone_types,id',
            'pearl_type_id' => 'nullable|exists:pearl_types,id',
            'quantity' => 'nullable|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cgst' => 'nullable|numeric|min:0',
            'sgst' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $variant->update([
            'product_code' => $request->product_code,
            'polish_type_id' => $request->polish_type_id,
            'stone_type_id' => $request->stone_type_id,
            'pearl_type_id' => $request->pearl_type_id,
            'quantity' => $request->quantity ?? 0,
            'base_price' => $request->base_price ?? 0,
            'discount_price' => $request->discount_price,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
            'weight' => $request->weight,
        ]);

        return redirect()->back()->with('success', 'Variant updated successfully.');
    }
    public function destroyVariant(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->back()->with('success', 'Variant deleted successfully.');
    }

    // ================== UNIQUE CODE GENERATOR ==================
    private function generateUniqueCode(string $prefix, string $table, string $column = 'product_code'): string
    {
        do {
            $code = $prefix . '-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 8));
        } while (DB::table($table)->where($column, $code)->exists());

        return $code;
    }





      public function syncSimilar(Request $request, Product $product)
    {
        $request->validate([
            'similar_ids'   => 'required|array|min:1',
            'similar_ids.*' => 'exists:products,id',
        ]);

        $ids = collect($request->similar_ids)
            ->reject(fn($id) => $id == $product->id) // can't link to itself
            ->unique()
            ->values();

        // Delete removed ones
        ProductSimilarItem::where('product_id', $product->id)
            ->whereNotIn('similar_product_id', $ids)
            ->delete();

        // Insert new ones
        foreach ($ids as $sid) {
            ProductSimilarItem::firstOrCreate([
                'product_id'        => $product->id,
                'similar_product_id'=> $sid,
            ]);
        }

        return redirect()->back()->with('success', 'Similar items updated successfully.');
    }

    /**
     * Remove a single similar item.
     */
    public function removeSimilar(Product $product, $similarProductId)
    {
        ProductSimilarItem::where('product_id', $product->id)
            ->where('similar_product_id', $similarProductId)
            ->delete();

        return redirect()->back()->with('success', 'Similar item removed.');
    }

    // ════════════════════════════════════════════════════════════
    //  COMPLETE THE LOOK
    // ════════════════════════════════════════════════════════════

    /**
     * Sync complete-the-look products (max 3).
     * Receives array of up to 3 product_ids in position order.
     */
    public function syncCompleteLook(Request $request, Product $product)
    {
        $request->validate([
            'look_ids'   => 'required|array|min:1|max:3',
            'look_ids.*' => 'exists:products,id',
        ]);

        $ids = collect($request->look_ids)
            ->reject(fn($id) => $id == $product->id)
            ->unique()
            ->take(3)
            ->values();

        // Wipe existing and re-insert with positions
        ProductCompleteLook::where('product_id', $product->id)->delete();

        foreach ($ids as $index => $lid) {
            ProductCompleteLook::create([
                'product_id'      => $product->id,
                'look_product_id' => $lid,
                'position'        => $index + 1,
            ]);
        }

        return redirect()->back()->with('success', 'Complete The Look updated successfully.');
    }

    /**
     * Remove a single complete-the-look product.
     */
    public function removeCompleteLook(Product $product, $lookProductId)
    {
        ProductCompleteLook::where('product_id', $product->id)
            ->where('look_product_id', $lookProductId)
            ->delete();

        // Re-number positions
        ProductCompleteLook::where('product_id', $product->id)
            ->orderBy('position')
            ->get()
            ->each(function ($item, $index) {
                $item->update(['position' => $index + 1]);
            });

        return redirect()->back()->with('success', 'Item removed from Complete The Look.');
    }

    // ════════════════════════════════════════════════════════════
    //  AJAX: fetch current linked items (for modal population)
    // ════════════════════════════════════════════════════════════

    public function getSimilar(Product $product)
    {
        $items = $product->similarProducts()->get()->map(fn($p) => [
            'id'           => $p->id,
            'product_code' => $p->product_code,
            'base_name'    => $p->base_name,
            'base_price'   => $p->base_price,
            'image'        => $p->images->first()?->image,
        ]);

        return response()->json($items);
    }

    public function getCompleteLook(Product $product)
    {
        $items = $product->completeLookProducts()->get()->map(fn($p) => [
            'id'           => $p->id,
            'product_code' => $p->product_code,
            'base_name'    => $p->base_name,
            'base_price'   => $p->base_price,
            'position'     => $p->pivot->position,
            'image'        => $p->images->first()?->image,
        ]);

        return response()->json($items);
    }
}
