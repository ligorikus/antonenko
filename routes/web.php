<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $categories = \App\Category::with('options')->get();
    return view('welcome', compact('categories'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');
});

Route::get('ajax/products', function (\Illuminate\Http\Request $request) {
    $products = \Illuminate\Support\Facades\DB::table('products')->distinct();
    $filter = $request->filter;
    if (isset($filter['name'])) {
        $products->where('products.name', 'ilike', '%'.$filter['name'].'%');
    }
    if (isset($filter['category_id'])) {
        $products->where('category_id', (int)$filter['category_id']);
    }
    if (isset($filter['options'])) {
        $products->leftJoin('product_options', 'product_options.product_id', '=', 'products.id');
        $products->where(function ($query) use ($filter) {
            foreach ($filter['options'] as $key => $option) {
                $query->orWhere('product_options.category_option_id', (int)$key);
                if (is_array($option)) {
                    $query
                        ->where('value', '>=', (int)$option[0])
                        ->where('value', '<=', (int)$option[1]);
                } else {
                    $query
                        ->where('value', (bool)$option);
                }
            }
        });
    }
    $products->leftJoin('categories', 'categories.id', '=', 'products.category_id');
    $products->select([
        'products.id',
        'products.name',
        'products.description',
        'products.image',
        'categories.name as category_name'
    ]);
    return $products->paginate(6);
});

Route::get('products/{product}/show', function (\App\Product $product) {
    $product->load('category_options');
    return view('products.show', compact('product'));
});

Route::post('products/img/product', function (\Illuminate\Http\Request $request) {
    $file = $request->file('image');
    if ($file) {
        $path = $file->store('public/images');
        if ($path) {
            return response()->json([
                'result' => true,
                'location' => env('APP_URL').\Illuminate\Support\Facades\Storage::url($path),
            ]);
        }

        return response()->json(['result' => false]);
    }

    return response()->json(['result' => false]);
});
