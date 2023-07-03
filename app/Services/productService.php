<?php

use App\Models\Image;
use App\Models\Product;

class productServices {
    public function productData($request, $id=null){

        if($id){
            $product = Product::find($id);
            if(!$product){
                //return 404 Page
                return back();
            }
        }else{
            $product = new Product();
        }
            
            // Update the product's other attributes if needed
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->save();
           
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/images', $filename);
                
                // Create a new image record
                $image = new Image();
                $image->name = $filename;
                $image->product_id = $product->id;
                $image->timestamps = false;
                $image->save();
            }
    }
}
