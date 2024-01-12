<?php

namespace App\Http\Controllers\Admin;

use App\CPU\BackEndHelper;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\BaseController;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\Color;
use App\Model\DealOfTheDay;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Review;
use App\Model\Translation;
use App\Model\Wishlist;
use App\Model\WholeSale;
use App\Model\ProductQuestion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use function App\CPU\translate;
use App\Model\Cart;

class ProductController extends BaseController
{
    public function add_new()
    {
        $cat = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $digital_product_setting = BusinessSetting::where('type', 'digital_product')->first()->value;
        return view('admin-views.product.add-new', compact('cat', 'br', 'brand_setting', 'digital_product_setting'));
    }

    public function featured_status(Request $request)
    {
        $product = Product::find($request->id);
        $product->featured = ($product['featured'] == 0 || $product['featured'] == null) ? 1 : 0;
        $product->save();
        $data = $request->status;
        return response()->json($data);
    }

    public function approve_status(Request $request)
    {
        $product = Product::find($request->id);
        $product->request_status = ($product['request_status'] == 0) ? 1 : 0;
        $product->save();

        return redirect()->route('admin.product.list', ['seller', 'status' => $product['request_status']]);
    }

    public function deny(Request $request)
    {
        $product = Product::find($request->id);
        $product->request_status = 2;
        $product->denied_note = $request->denied_note;
        $product->save();

        return redirect()->route('admin.product.list', ['seller', 'status' => 2]);
    }

    public function view($id)
    {
        $product = Product::with(['reviews'])->where(['id' => $id])->first();
        $reviews = Review::where(['product_id' => $id])->paginate(Helpers::pagination_limit());
        return view('admin-views.product.view', compact('product', 'reviews'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'                 => 'required',
            'category_id'          => 'required',
            'product_type'         => 'required',
            'digital_product_type' => 'required_if:product_type,==,digital',
            'digital_file_ready'   => 'required_if:digital_product_type,==,ready_product|mimes:jpg,jpeg,png,gif,zip,pdf',
            'unit'                 => 'required_if:product_type,==,physical',
            'images'               => 'required',
            'image'                => 'required',
            'tax'                  => 'required|min:0',
            'unit_price'           => 'required|numeric|min:1',
            'purchase_price'       => 'required|numeric|min:1',
            'discount'             => 'required|gt:-1',
            'shipping_cost'        => 'required_if:product_type,==,physical|gt:-1',
            'code'                 => 'required|numeric|min:1|digits_between:6,20|unique:products',
            'minimum_order_qty'    => 'required|numeric|min:1',
        ], [
            'images.required'                  => 'Product images is required!',
            'image.required'                   => 'Product thumbnail is required!',
            'category_id.required'             => 'Category is required!',
            'unit.required_if'                 => 'Unit is required!',
            'code.min'                         => 'Code must be positive!',
            'code.digits_between'              => 'Code must be minimum 6 digits!',
            'minimum_order_qty.required'       => 'Minimum order quantity is required!',
            'minimum_order_qty.min'            => 'Minimum order quantity must be positive!',
            'digital_file_ready.required_if'   => 'Ready product upload is required!',
            'digital_file_ready.mimes'         => 'Ready product upload must be a file of type: pdf, zip, jpg, jpeg, png, gif.',
            'digital_product_type.required_if' => 'Digital product type is required!',
            'shipping_cost.required_if'        => 'Shipping Cost is required!',
        ]);

        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        if ($brand_setting && empty($request->brand_id)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'brand_id',
                    'Brand is required!'
                );
            });
        }

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'unit_price',
                    'Discount can not be more or equal to the price!'
                );
            });
        }

        if (is_null($request->name[array_search('en', $request->lang)])) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
                );
            });
        }

        $p = new Product();
        $p->user_id  = auth('admin')->id();
        $p->added_by = "admin";
        $p->name     = $request->name[array_search('en', $request->lang)];
        $p->code     = $request->code;
        $p->slug     = Str::slug($request->name[array_search('en', $request->lang)], '-') . '-' . Str::random(6);

        $category = [];

        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);
        }
        if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        if ($request->sub_sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_sub_category_id,
                'position' => 3,
            ]);
        }

        $p->category_ids         = json_encode($category);
        $p->brand_id             = $request->brand_id;
        $p->unit                 = $request->product_type == 'physical' ? $request->unit : null;
        $p->digital_product_type = $request->product_type == 'digital' ? $request->digital_product_type : null;
        $p->product_type         = $request->product_type;
        $p->details              = $request->description[array_search('en', $request->lang)];

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $p->colors = $request->product_type == 'physical' ? json_encode($request->colors) : json_encode([]);
        } else {
            $colors = [];
            $p->colors = $request->product_type == 'physical' ? json_encode($colors) : json_encode([]);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $p->choice_options = $request->product_type == 'physical' ? json_encode($choice_options) : json_encode([]);
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options

        $combinations = Helpers::combinations($options);

        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = BackEndHelper::currency_to_usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = abs($request['qty_' . str_replace('.', '_', $str)]);
                array_push($variations, $item);
                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        //combinations end
        $p->variation         = $request->product_type == 'physical' ? json_encode($variations) : json_encode([]);
        $p->unit_price        = BackEndHelper::currency_to_usd($request->unit_price);
        $p->purchase_price    = BackEndHelper::currency_to_usd($request->purchase_price);
        $p->tax               = $request->tax_type == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $p->tax_type          = $request->tax_type;
        $p->discount          = $request->discount_type == 'flat' ? BackEndHelper::currency_to_usd($request->discount) : $request->discount;
        $p->discount_type     = $request->discount_type;
        $p->attributes        = $request->product_type == 'physical' ? json_encode($request->choice_attributes) : json_encode([]);
        $p->current_stock     = $request->product_type == 'physical' ? abs($stock_count) : 0;
        $p->minimum_order_qty = $request->minimum_order_qty;
        $p->video_provider    = 'youtube';
        $p->video_url         = $request->video_link;
        $p->request_status    = 1;
        $p->shipping_cost     = $request->product_type == 'physical' ? BackEndHelper::currency_to_usd($request->shipping_cost) : 0;
        $p->multiply_qty      = ($request->product_type == 'physical') ? ($request->multiplyQTY == 'on' ? 1 : 0) : 0;
     
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            if ($request->file('images')) {
                foreach ($request->file('images') as $img) {
                    $product_images[] = ImageManager::upload('product/', 'png', $img);
                }
                $p->images = json_encode($product_images);
            }

            // dd($request->image);
            $p->thumbnail = ImageManager::upload('product/thumbnail/', 'png', $request->image);

            if ($request->product_type == 'digital' && $request->digital_product_type == 'ready_product') {
                $p->digital_file_ready = ImageManager::upload('product/digital-product/', $request->digital_file_ready->getClientOriginalExtension(), $request->digital_file_ready);
            }

            $p->meta_title       = $request->meta_title;
            $p->meta_description = $request->meta_description;
            $p->specifications = $request->specifications;
            $p->loyalty_point = $request->loyalty_point ?? 0;
            $p->quick_links = $request->quick_links;
            $p->features = $request->features;
            $p->meta_image       = ImageManager::upload('product/meta/', 'png', $request->meta_image);
            $p->is_emi = $request->is_emi;
            $p->save();
            #courier data insert
            $productId = $p->id;
            $courier = $request->courier_amount;
            foreach ($courier as $key => $data) {
                $courier = [
                    "product_id" => $productId,
                    "courier_id" => $key,
                    "amount" => $data ?? 0,
                ];
                DB::table('product_wise_courier')->insert($courier);
            }
               #whole sale
           $check=DB::table('wholesale_prices')->where('product_stock_id',$productId)->first();
            if(empty($request->wholesale_price) && isset($check))
            {
                DB::table('wholesale_prices')->where('product_stock_id',$productId)->delete();
            }
            if($request->has('wholesale_price')){
                DB::table('wholesale_prices')->where('product_stock_id',$productId)->delete();
                foreach($request->wholesale_price as $key => $price){
                        $wholesale_price = [
                            "product_stock_id"=>$productId,
                            "min_qty" => $request->wholesale_min_qty[$key],
                            "max_qty" => $request->wholesale_max_qty[$key],
                            "price" => $price,
                        ];
                        DB::table('wholesale_prices')->insert($wholesale_price);
                }  
            }
            $data = [];
            foreach ($request->lang as $index => $key) {
                if ($request->name[$index] && $key != 'en') {
                    array_push($data, array(
                        'translationable_type' => 'App\Model\Product',
                        'translationable_id' => $p->id,
                        'locale' => $key,
                        'key' => 'name',
                        'value' => $request->name[$index],
                    ));
                }
                if ($request->description[$index] && $key != 'en') {
                    array_push($data, array(
                        'translationable_type' => 'App\Model\Product',
                        'translationable_id' => $p->id,
                        'locale' => $key,
                        'key' => 'description',
                        'value' => $request->description[$index],
                    ));
                }
            }
            Translation::insert($data);

            Toastr::success(translate('Product added successfully!'));
            return redirect()->route('admin.product.list', ['in_house']);
        }
    }

    function list(Request $request, $type)
    {
        $query_param = [];
        $search = $request['search'];
        if ($type == 'in_house') {
            $pro = Product::where(['added_by' => 'admin']);
        } else {
            $pro = Product::where(['added_by' => 'seller'])->where('request_status', $request->status);
        }

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $pro = $pro->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }

        $request_status = $request['status'];
        $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends(['status' => $request['status']])->appends($query_param);
        return view('admin-views.product.list', compact('pro', 'search', 'request_status', 'type'));
    }
    public function pos_quickStore(Request $request)
    {
        try {
            $p = new Product();
            $p->user_id = auth('admin')->id();
            $p->added_by = "admin";
            $p->name = $request->name;
            $p->details = $request->description;
            $p->short_description = $request->description;
            $p->current_stock = 100;
            $p->variation = '[]';
            $p->choice_options = '[]';
            $p->colors = '[]';
            $p->images = '[]';
            $p->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

            $category = [];

            if ($request->category_id != null) {
                array_push($category, [
                    'id' => $request->category_id,
                    'position' => 1,
                ]);
            }
            $p->category_ids = json_encode($category);
            $p->unit_price = BackEndHelper::currency_to_usd($request->unit_price);
            $p->status = 0;
            $p->save();
            Toastr::success(translate('Product added successfully!'));
            return redirect()->route('admin.pos.index');

        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    function questions(Request $request)
    {
        $questions = ProductQuestion::orderBy('id', 'desc')->paginate(25);
        return view('admin-views.product.questions', compact('questions'));
    }
    function questions_answer($id)
    {
        $ans_question = DB::table('product_questions')
            ->join('products', 'products.id', 'product_questions.product_id')
            ->select('products.name', 'product_questions.question', 'product_questions.id as question_id')
            ->where('product_questions.id', $id)
            ->first();
        return view('admin-views.product.answer', compact('ans_question'));
    }
    function answer_submit(Request $request)
    {
        $data = [
            'answer' => $request->answer,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        DB::table('product_questions')->where('id', $request->question_id)->update($data);
        Toastr::success('Answer has successfully Submit!');
        return redirect()->route('admin.product.questions');
    }
    /**
     * Export product list by excel
     * @param Request $request
     * @param $type
     */
    public function export_excel(Request $request, $type)
    {
        $products = Product::when($type == 'in_house', function ($q) {
            $q->where(['added_by' => 'admin']);
        })->when($type != 'in_house', function ($q) use ($request) {
            $q->where(['added_by' => 'seller'])->where('request_status', $request->status);
        })->latest()->get();
        //export from product
        $data = [];
        foreach ($products as $item) {
            $category_id = 0;
            $sub_category_id = 0;
            $sub_sub_category_id = 0;
            foreach (json_decode($item->category_ids, true) as $category) {
                if ($category['position'] == 1) {
                    $category_id = $category['id'];
                } else if ($category['position'] == 2) {
                    $sub_category_id = $category['id'];
                } else if ($category['position'] == 3) {
                    $sub_sub_category_id = $category['id'];
                }
            }
            $data[] = [
                'product_id' => $item->id,
                'name' => $item->name,
                'Product Type'          => $item->product_type,
                'category_id'           => $category_id,
                'sub_category_id'       => $sub_category_id,
                'sub_sub_category_id'   => $sub_sub_category_id,
                'brand_id'              => $item->brand_id,
                'unit'                  => $item->unit,
                'min_qty'               => $item->min_qty,
                'refundable'            => $item->refundable,
                'youtube_video_url'     => $item->video_url,
                'unit_price'            => $item->unit_price,
                'purchase_price'        => $item->purchase_price,
                'tax'                   => $item->tax,
                'discount'              => $item->discount,
                'discount_type'         => $item->discount_type,
                'current_stock'         => $item->product_type == 'physical' ? $item->current_stock : null,
                'details'               => $item->details,
                'thumbnail'             => 'thumbnail/' . $item->thumbnail,
                'Status'                => $item->status == 1 ? 'Active' : 'Inactive',
            ];
        }

        return (new FastExcel($data))->download('product_list.xlsx');
    }

    public function updated_product_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $pro = Product::where(['added_by' => 'seller'])
                ->where('is_shipping_cost_updated', 0)
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('name', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $pro = Product::where(['added_by' => 'seller'])->where('is_shipping_cost_updated', 0);
        }
        $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.product.updated-product-list', compact('pro', 'search'));
    }

    public function stock_limit_list(Request $request, $type)
    {
        $stock_limit = Helpers::get_business_settings('stock_limit');
        $sort_oqrderQty = $request['sort_oqrderQty'];
        $query_param = $request->all();
        $search = $request['search'];
        if ($type == 'in_house') {
            $pro = Product::where(['added_by' => 'admin', 'product_type' => 'physical']);
        } else {
            $pro = Product::where(['added_by' => 'seller', 'product_type' => 'physical'])->where('request_status', $request->status);
        }

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $pro = $pro->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }

        $request_status = $request['status'];

        $pro = $pro->withCount('order_details')->when($request->sort_oqrderQty == 'quantity_asc', function ($q) use ($request) {
            return $q->orderBy('current_stock', 'asc');
        })
            ->when($request->sort_oqrderQty == 'quantity_desc', function ($q) use ($request) {
                return $q->orderBy('current_stock', 'desc');
            })
            ->when($request->sort_oqrderQty == 'order_asc', function ($q) use ($request) {
                return $q->orderBy('order_details_count', 'asc');
            })
            ->when($request->sort_oqrderQty == 'order_desc', function ($q) use ($request) {
                return $q->orderBy('order_details_count', 'desc');
            })
            ->when($request->sort_oqrderQty == 'default', function ($q) use ($request) {
                return $q->orderBy('id');
            })->where('current_stock', '<', $stock_limit);

        $pro = $pro->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends(['status' => $request['status']])->appends($query_param);
        return view('admin-views.product.stock-limit-list', compact('pro', 'search', 'request_status', 'sort_oqrderQty', 'stock_limit'));
    }

    public function update_quantity(Request $request)
    {
        $variations = [];
        $stock_count = $request['current_stock'];
        if ($request->has('type')) {
            foreach ($request['type'] as $key => $str) {
                $item = [];
                $item['type'] = $str;
                $item['price'] = BackEndHelper::currency_to_usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = abs($request['qty_' . str_replace('.', '_', $str)]);
                array_push($variations, $item);
            }
        }

        $product = Product::find($request['product_id']);
        if ($stock_count >= 0) {
            $product->current_stock = $stock_count;
            $product->variation = json_encode($variations);
            $product->save();
            Toastr::success(\App\CPU\translate('product_quantity_updated_successfully!'));
            return back();
        } else {
            Toastr::warning(\App\CPU\translate('product_quantity_can_not_be_less_than_0_!'));
            return back();
        }
    }

    public function status_update(Request $request)
    {

        $product = Product::where(['id' => $request['id']])->first();
        $success = 1;

        if ($request['status'] == 1) {
            if ($product->added_by == 'seller' && ($product->request_status == 0 || $product->request_status == 2)) {
                $success = 0;
            } else {
                $product->status = $request['status'];
            }
        } else {
            $product->status = $request['status'];
        }
        $product->save();
        return response()->json([
            'success' => $success,
        ], 200);
    }
    public function updated_shipping(Request $request)
    {

        $product = Product::where(['id' => $request['product_id']])->first();
        if ($request->status == 1) {
            $product->shipping_cost = $product->temp_shipping_cost;
            $product->is_shipping_cost_updated = $request->status;
        } else {
            $product->is_shipping_cost_updated = $request->status;
        }

        $product->save();
        return response()->json([], 200);
    }

    public function get_categories(Request $request)
    {
        $cat = Category::where(['parent_id' => $request->parent_id])->get();
        $res = '<option value="' . 0 . '" disabled selected>---Select---</option>';
        foreach ($cat as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }

    public function sku_combination(Request $request)
    {
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name[array_search('en', $request->lang)];

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        return response()->json([
            'view' => view('admin-views.product.partials._sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'))->render(),
        ]);
    }

    public function get_variations(Request $request)
    {
        $product = Product::find($request['id']);
        return response()->json([
            'view' => view('admin-views.product.partials._update_stock', compact('product'))->render()
        ]);
    }

    public function edit($id)
    {
        $product = Product::withoutGlobalScopes()->with('translations')->find($id);
        $product_category = json_decode($product->category_ids);
        $product->colors = json_decode($product->colors);
        $categories = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $digital_product_setting = BusinessSetting::where('type', 'digital_product')->first()->value;

        return view('admin-views.product.edit', compact('categories', 'br', 'product', 'product_category', 'brand_setting', 'digital_product_setting'));
    }

    public function update(Request $request, $id)
    {

        $product = Product::find($id);
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'category_id'           => 'required',
            'product_type'          => 'required',
            'digital_product_type'  => 'required_if:product_type,==,digital',
            'digital_file_ready'    => 'mimes:jpg,jpeg,png,gif,zip,pdf',
            'unit'                  => 'required_if:product_type,==,physical',
            'tax'                   => 'required|min:0',
            'unit_price'            => 'required|numeric|min:1',
            'purchase_price'        => 'required|numeric|min:1',
            'discount'              => 'required|gt:-1',
            'shipping_cost'         => 'required_if:product_type,==,physical|gt:-1',
            'code'                  => 'required|numeric|min:1|digits_between:6,20|unique:products,code,' . $product->id,
            'minimum_order_qty'     => 'required|numeric|min:1',
        ], [
            'name.required'                     => 'Product name is required!',
            'category_id.required'              => 'category  is required!',
            'unit.required_if'                  => 'Unit  is required!',
            'code.min'                          => 'Code must be positive!',
            'code.digits_between'               => 'Code must be minimum 6 digits!',
            'minimum_order_qty.required'        => 'Minimum order quantity is required!',
            'minimum_order_qty.min'             => 'Minimum order quantity must be positive!',
            'digital_file_ready.mimes'          => 'Ready product upload must be a file of type: pdf, zip, jpg, jpeg, png, gif.',
            'digital_product_type.required_if'  => 'Digital product type is required!',
            'shipping_cost.required_if'         => 'Shipping Cost is required!',
        ]);

        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        if ($brand_setting && empty($request->brand_id)) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'brand_id',
                    'Brand is required!'
                );
            });
        }

        if (
            ($request->product_type == 'digital') &&
            ($request->digital_product_type == 'ready_product') &&
            empty($product->digital_file_ready) &&
            !$request->file('digital_file_ready')
        ) {
            $validator->after(function ($validator) {
                $validator->errors()->add('digital_file_ready', 'Ready product upload is required!');
            });
        }

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            $validator->after(function ($validator) {
                $validator->errors()->add('unit_price', 'Discount can not be more or equal to the price!');
            });
        }

        if (is_null($request->name[array_search('en', $request->lang)])) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name',
                    'Name field is required!'
                );
            });
        }

        $product->name = $request->name[array_search('en', $request->lang)];

        $category = [];
        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);
        }
        if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        if ($request->sub_sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_sub_category_id,
                'position' => 3,
            ]);
        }

        $product->product_type          = $request->product_type;
        $product->category_ids          = json_encode($category);
        $product->brand_id              = isset($request->brand_id) ? $request->brand_id : null;
        $product->unit                  = $request->product_type == 'physical' ? $request->unit : null;
        $product->digital_product_type  = $request->product_type == 'digital' ? $request->digital_product_type : null;
        $product->code                  = $request->code;
        $product->minimum_order_qty     = $request->minimum_order_qty;
        $product->details               = $request->description[array_search('en', $request->lang)];
        $product_images                 = json_decode($product->images);

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = $request->product_type == 'physical' ? json_encode($request->colors) : json_encode([]);
        } else {
            $colors = [];
            $product->colors = json_encode($colors);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $product->choice_options = $request->product_type == 'physical' ? json_encode($choice_options) : json_encode([]);
        $variations = [];
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
        $combinations = Helpers::combinations($options);
        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = BackEndHelper::currency_to_usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = abs($request['qty_' . str_replace('.', '_', $str)]);
                array_push($variations, $item);
                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)
        //         ->withInput();
        // }

        //combinations end
        $product->variation      = $request->product_type == 'physical' ? json_encode($variations) : json_encode([]);
        $product->unit_price     = BackEndHelper::currency_to_usd($request->unit_price);
        $product->purchase_price = BackEndHelper::currency_to_usd($request->purchase_price);
        $product->tax            = $request->tax == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $product->tax_type       = $request->tax_type;
        $product->discount       = $request->discount_type == 'flat' ? BackEndHelper::currency_to_usd($request->discount) : $request->discount;
        $product->attributes     = $request->product_type == 'physical' ? json_encode($request->choice_attributes) : json_encode([]);
        $product->discount_type  = $request->discount_type;
        $product->current_stock  = $request->product_type == 'physical' ? abs($stock_count) : 0;

        $product->video_provider = 'youtube';
        $product->video_url = $request->video_link;
        if ($product->added_by == 'seller' && $product->request_status == 2) {
            $product->request_status = 1;
        }

        $product->shipping_cost = $request->product_type == 'physical' ? BackEndHelper::currency_to_usd($request->shipping_cost) : 0;
        $product->multiply_qty = ($request->product_type == 'physical') ? ($request->multiplyQTY == 'on' ? 1 : 0) : 0;
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            if ($request->file('images')) {
                foreach ($request->file('images') as $img) {
                    $product_images[] = ImageManager::upload('product/', 'png', $img);
                }
                $product->images = json_encode($product_images);
            }

            if ($request->file('image')) {
                $product->thumbnail = ImageManager::update('product/thumbnail/', $product->thumbnail, 'png', $request->file('image'));
            }

            if ($request->product_type == 'digital') {
                if ($request->digital_product_type == 'ready_product' && $request->hasFile('digital_file_ready')) {
                    $product->digital_file_ready = ImageManager::update('product/digital-product/', $product->digital_file_ready, $request->digital_file_ready->getClientOriginalExtension(), $request->file('digital_file_ready'));
                } elseif (($request->digital_product_type == 'ready_after_sell') && $product->digital_file_ready) {
                    ImageManager::delete('product/digital-product/' . $product->digital_file_ready);
                    $product->digital_file_ready = null;
                }
            } elseif ($request->product_type == 'physical' && $product->digital_file_ready) {
                ImageManager::delete('product/digital-product/' . $product->digital_file_ready);
                $product->digital_file_ready = null;
            }
            $product->meta_title = $request->pmeta_title;
            $product->meta_description = $request->meta_description;
            $product->specifications = $request->specifications;
            $product->loyalty_point = $request->loyalty_point ?? 0;
            $product->quick_links = $request->quick_links;
            $product->features = $request->features;
            if ($request->file('meta_image')) {
                $product->meta_image = ImageManager::update('product/meta/', $product->meta_image, 'png', $request->file('meta_image'));
            }
            $product->is_emi = $request->is_emi;
            $product->save();
            #courier update
            $courier = $request->courier_amount;
            foreach ($courier as $key => $data) {
                $check = DB::table('product_wise_courier')->where('product_id', $product->id)->where('courier_id', $key)->first();
                if (!empty($check)) {
                    $courier = [
                        "amount" => $data,
                    ];
                    DB::table('product_wise_courier')->where('product_id', $product->id)->where('courier_id', $key)->update($courier);
                } else {
                    $courier = [
                        "product_id" => $product->id,
                        "courier_id" => $key,
                        "amount" => $data,
                    ];
                    DB::table('product_wise_courier')->insert($courier);
                }
            }
            #whole sale

            $check=DB::table('wholesale_prices')->where('product_stock_id',$product->id)->first();
            if(empty($request->wholesale_price) && isset($check))
            {
                DB::table('wholesale_prices')->where('product_stock_id',$product->id)->delete();
            }
            if($request->has('wholesale_price')){
                DB::table('wholesale_prices')->where('product_stock_id',$product->id)->delete();
                foreach($request->wholesale_price as $key => $price){
                        $wholesale_price = [
                            "product_stock_id"=>$product->id,
                            "min_qty" => $request->wholesale_min_qty[$key],
                            "max_qty" => $request->wholesale_max_qty[$key],
                            "price" => $price,
                        ];
                        DB::table('wholesale_prices')->insert($wholesale_price);
                }  
            }
            foreach ($request->lang as $index => $key) {
                if ($request->name[$index] && $key != 'en') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Model\Product',
                            'translationable_id' => $product->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $request->name[$index]]
                    );
                }
                if ($request->description[$index] && $key != 'en') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Model\Product',
                            'translationable_id' => $product->id,
                            'locale' => $key,
                            'key' => 'description'
                        ],
                        ['value' => $request->description[$index]]
                    );
                }
            }
            Toastr::success('Product updated successfully.');
            return back();
        }
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/product/' . $request['image']);
        $product = Product::find($request['id']);
        $array = [];
        if (count(json_decode($product['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($product['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Product::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Product image removed successfully!');
        // return back();
        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $translation = Translation::where('translationable_type', 'App\Model\Product')
            ->where('translationable_id', $id);
        $translation->delete();

        Cart::where('product_id', $product->id)->delete();
        Wishlist::where('product_id', $product->id)->delete();

        foreach (json_decode($product['images'], true) as $image) {
            ImageManager::delete('/product/' . $image);
        }
        ImageManager::delete('/product/thumbnail/' . $product['thumbnail']);
        $product->delete();

        FlashDealProduct::where(['product_id' => $id])->delete();
        DealOfTheDay::where(['product_id' => $id])->delete();

        Toastr::success('Product removed successfully!');
        return back();
    }

    public function bulk_import_index()
    {
        return view('admin-views.product.bulk-import');
    }

    public function bulk_import_data(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('products_file'));
        } catch (\Exception $exception) {
            Toastr::error('You have uploaded a wrong format file, please upload the right file.');
            return back();
        }


        $data = [];
        $col_key = ['name', 'category_id', 'sub_category_id', 'sub_sub_category_id', 'brand_id', 'unit', 'min_qty', 'refundable', 'youtube_video_url', 'unit_price', 'purchase_price', 'tax', 'discount', 'discount_type', 'current_stock', 'details', 'specifications', 'quick_links', 'features', 'sku', 'shipping_cost', 'seo_meta_title', 'seo_meta_description', 'seo_meta_image', 'shipping_cost_multiply_with_quantity', 'thumbnail', 'image'];
        $skip = ['youtube_video_url', 'details', 'thumbnail', 'image', 'seo_meta_image', 'specifications', 'quick_links', 'features', 'sku', 'shipping_cost', 'seo_meta_title', 'seo_meta_description', 'seo_meta_image', 'shipping_cost_multiply_with_quantity'];

        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($key != "" && !in_array($key, $col_key)) {
                    Toastr::error('Please upload the correct format file.');
                    return back();
                }

                if ($key != "" && $value === "" && !in_array($key, $skip)) {
                    Toastr::error('Please fill ' . $key . ' fields');
                    return back();
                }
            }

            $thumbnail = null;
            if ($collection['thumbnail'] && filter_var($collection['thumbnail'], FILTER_VALIDATE_URL)) {
                try {
                    //   $image = file_get_contents($collection['thumbnail']);
                    //   $imagePath = storage_path('product/image/thumbnail');
                    //   $imagePathName = $imagePath . '/' . str_replace(" ", '', $collection['name']) . time() . '.png';
                    //   file_put_contents($imagePathName, $image);
                    $imagePathName = $collection['thumbnail'];
                    // $path_info = pathinfo($collection['thumbnail']);
                    // $thumbExtension = $path_info['extension'];

                    $thumbnail = ImageManager::upload('product/thumbnail/', 'png', $imagePathName, true);
                    //   $thumbnail = ImageManager::upload('product/thumbnail/', 'png', $imagePathName);
                } catch (\Exception $exception) {
                    //   dd('in catch ' . $exception->getMessage());
                    $thumbnail = null;
                }
            }
            $seo_meta_image = null;

            if ($collection['seo_meta_image'] && filter_var($collection['seo_meta_image'], FILTER_VALIDATE_URL)) {
                try {

                    $imagePathName = $collection['seo_meta_image'];

                    $seo_meta_image = ImageManager::upload('product/meta/', 'png', $imagePathName, true);
                } catch (\Exception $exception) {
                    $seo_meta_image = null;
                }
            }

            $product_images = array();
            if ($collection['image'] && filter_var($collection['image'], FILTER_VALIDATE_URL)) {
                try {
                    // $image = file_get_contents($collection['image']);
                    // $imagePath = storage_path('product/image/main');
                    // $imagePathName = $imagePath . '/' . str_replace(" ", '', $collection['name']) . time() . '.png';
                    // file_put_contents($imagePathName, $image);
                    $imagePathName = $collection['image'];
                    // $path_info = pathinfo($collection['image']);
                    // $mainExtension = $path_info['extension'];
                    $product_images[] = ImageManager::upload('product/', 'png', $imagePathName, true);
                    // $product_images[] = ImageManager::upload('product/', 'png', $imagePathName);
                } catch (\Exception $exception) {
                    $product_images = ['def.png'];
                }
            } else {
                $product_images = ['def.png'];
            }

            $category = [];

            if ($collection['category_id'] != null || $collection['category_id'] != 0) {
                array_push($category, [
                    'id' => $collection['category_id'],
                    'position' => 1,
                ]);
            }
            if ($collection['sub_category_id'] != null || $collection['sub_category_id'] != 0) {
                array_push($category, [
                    'id' => $collection['sub_category_id'],
                    'position' => 2,
                ]);
            }
            if ($collection['sub_sub_category_id'] != null || $collection['sub_sub_category_id'] != 0) {
                array_push($category, [
                    'id' => $collection['sub_sub_category_id'],
                    'position' => 3,
                ]);
            }


            array_push($data, [
                'name' => $collection['name'],
                'slug' => Str::slug($collection['name'], '-') . '-' . Str::random(6),
                'category_ids' => json_encode($category),
                'brand_id' => $collection['brand_id'],
                'unit' => $collection['unit'],
                'min_qty' => $collection['min_qty'],
                'refundable' => $collection['refundable'],
                'unit_price' => $collection['unit_price'],
                'purchase_price' => $collection['purchase_price'],
                'tax' => $collection['tax'],
                'discount' => $collection['discount'],
                'discount_type' => $collection['discount_type'],
                'current_stock' => $collection['current_stock'],
                'details' => $this->custom_filter_html_data($collection['details']),
                'video_provider' => 'youtube',
                'video_url' => $collection['youtube_video_url'],
                'images' => json_encode($product_images),
                'thumbnail' => $thumbnail,
                'status' => 1,
                'request_status' => 1,
                'colors' => json_encode([]),
                'attributes' => json_encode([]),
                'choice_options' => json_encode([]),
                'variation' => json_encode([]),
                'featured_status' => 1,
                'code' => (isset($collection['sku']) && $collection['sku'] != '') ? $collection['sku'] : " ",
                'features' => (isset($collection['features']) && $collection['features'] != '') ? $this->custom_filter_html_data($collection['features']) : null,
                'quick_links' => (isset($collection['quick_links']) && $collection['quick_links'] != '') ? $this->custom_filter_html_data($collection['quick_links']) : null,
                'specifications' => (isset($collection['specifications']) && $collection['specifications'] != '') ? $this->custom_filter_html_data($collection['specifications']) : null,
                'shipping_cost' => (isset($collection['shipping_cost']) && $collection['shipping_cost'] != '') ? $collection['shipping_cost'] : "",
                'multiply_qty' => (isset($collection['shipping_cost_multiply_with_quantity']) && $collection['shipping_cost_multiply_with_quantity'] != '') ? $collection['shipping_cost_multiply_with_quantity'] : "",
                'meta_image' => $seo_meta_image,
                'meta_title' => (isset($collection['seo_meta_title']) && $collection['seo_meta_title'] != '') ? $collection['seo_meta_title'] : "",
                'meta_description' => (isset($collection['seo_meta_description']) && $collection['seo_meta_description'] != '') ? $collection['seo_meta_description'] : " ",
                'added_by' => 'admin',
                'user_id' => auth('admin')->id(),
            ]);
        }

        DB::table('products')->insert($data);
        Toastr::success(count($data) . ' - Products imported successfully!');
        return back();
    }

    public function custom_filter_html_data($content)
    {
        $customHtml = '';
        if (!empty($content)) {
            $filterContent = explode('_x000D_\n_x000D_\n', $content);
            if (sizeof($filterContent) > 0) {
                foreach ($filterContent as $t) {
                    $strip_tag = strip_tags($t, '<span>');
                    $customHtml .= '<p>' . $strip_tag . '</p>';
                }
            }
        }

        return $customHtml;
    }

    public function bulk_export_data()
    {

        $products = Product::where(['added_by' => 'admin'])->get();
        //export from product
        $storage = [];
        foreach ($products as $item) {
            $category_id = 0;
            $sub_category_id = 0;
            $sub_sub_category_id = 0;
            foreach (json_decode($item->category_ids, true) as $category) {
                if ($category['position'] == 1) {
                    $category_id = $category['id'];
                } else if ($category['position'] == 2) {
                    $sub_category_id = $category['id'];
                } else if ($category['position'] == 3) {
                    $sub_sub_category_id = $category['id'];
                }
            }
            $storage[] = [
                'product_id' => $item->id,
                'name' => $item->name,
                'category_id' => $category_id,
                'sub_category_id' => $sub_category_id,
                'sub_sub_category_id' => $sub_sub_category_id,
                'brand_id' => $item->brand_id,
                'unit' => $item->unit,
                'min_qty' => $item->min_qty,
                'refundable' => $item->refundable,
                'youtube_video_url' => $item->video_url,
                'unit_price' => $item->unit_price,
                'purchase_price' => $item->purchase_price,
                'tax' => $item->tax,
                'discount' => $item->discount,
                'discount_type' => $item->discount_type,
                'current_stock' => $item->current_stock,
                'details' => $item->details,
                'thumbnail' => 'thumbnail/' . $item->thumbnail,
            ];
        }
        return (new FastExcel($storage))->download('inhouse_products.xlsx');
    }

    public function barcode(Request $request, $id)
    {

        if ($request->limit > 270) {
            Toastr::warning(translate('You can not generate more than 270 barcode'));
            return back();
        }
        $product = Product::findOrFail($id);
        $limit =  $request->limit ?? 4;
        return view('admin-views.product.barcode', compact('product', 'limit'));
    }

    // added for malamal
    /*quick store*/
   public function quickStore(Request $request)
    {

        if(isset($request->customer_name) && isset($request->subject_name))
        {
            session()->put('customer_id', $request->customer_name);
            session()->put('subject_line', $request->subject_name);
        }
        try {
            $p = new Product();
            $p->user_id = auth('admin')->id();
            $p->added_by = "admin";
            $p->name = $request->name;
            $p->details = $request->description;
            $p->short_description = $request->description;
            $p->current_stock = 100;
            $p->variation = '[]';
            $p->choice_options = '[]';
            $p->colors = '[]';
            $p->images = '[]';
            $p->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

            $category = [];

            if ($request->category_id != null) {
                array_push($category, [
                    'id' => $request->category_id,
                    'position' => 1,
                ]);
            }
            $p->category_ids = json_encode($category);
            $p->unit_price = BackEndHelper::currency_to_usd($request->unit_price);
            $p->status = 0;
            $p->save();

            $customer_id=isset($request->customer_name)?$request->customer_name:session()->get('customer_id');
            $subject_line=isset($request->subject_name)? $request->subject_name:session()->get('subject_line');

            if (isset($request->quotation) && $request->quotation == 1) {
                $cart = Session::get('quotation_cart') ?? [];
                if (array_search($p->id, array_column($cart, 'id')) !== FALSE) {
                    throw new \Exception("this product already added");
                }
                $cart[$p->id] = array(
                    "id" => $p->id,
                    "name" => $p->name,
                    "code" => $p->code,
                    "price" => $p->unit_price,
                    "qty" => 1,
                    "discount" => 0,
                    "vat" => 0,
                    "single_unit_vat" => 0,
                    "product_price" => $p->unit_price * 1,
                    "single_unit_price_vat" => $p->unit_price * 1,
                    "subtotal" => $p->unit_price,
                    "vat_rate" => 0,
                    "description" => isset($p->short_description) ? strip_tags($p->short_description) : "",
                );
                Session::put('quotation_cart', $cart);
                Toastr::success(translate('Product added successfully!'));
                if (isset($request->edit_mode) && $request->edit_mode == 1) {
                    return redirect()->route('admin.quotation.edit', [$request->quotation_no, 'customer_id' => $request->customer_name, 'subject_line' => $request->subject_name]);
                } else {
                    return redirect()->route('admin.quotation.add-new',['customer_id' => $customer_id, 'subject_line' => $subject_line]);
                }
            } else {
                Toastr::success(translate('Product added successfully!'));
                // return redirect()->back()->with(['customer_id' => $customer_id, 'subject_line' => $subject_line]);
                return redirect()->route('admin.quotation.add-new',['customer_id' => $customer_id, 'subject_line' => $subject_line]);
            }

            // return redirect()->back()->with(['customer_id' => $request->quotation_customer,'subject_line'=> $request->quotation_subject]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function bulk_update_index()
    {
        return view('admin-views.product.bulk-update');
    }

    public function bulk_update_data(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('products_file'));

            if (count($collections) > 100) {
                throw new \Exception("update product data not more than 100 items");
            }
        } catch (\Exception $exception) {
            $message = ($exception->getMessage()) ? $exception->getMessage() : "You have uploaded a wrong format file, please upload the right file.";
            Toastr::error($message);
            return back();
        }
        if (count($collections)) {
            $updatedProduct = [];
            foreach ($collections as $collection) {

                $productData = Product::where('id', $collection['product_id'])->first();
                if (!$productData) {
                    continue;
                }
                try {
                    $productData->name = $collection['name'];
                    $productData->product_type = $collection['product_type'];
                    $productData->category_ids = json_encode([['id' => (string)$collection['category_id'], 'position' => 1], ['id' => (string)$collection['sub_category_id'], 'position' => 2], ['id' => (string)$collection['sub_sub_category_id'], 'position' => 3]]);
                    $productData->brand_id = $collection['brand_id'];
                    $productData->unit_price = $collection['unit_price'];
                    $productData->purchase_price = $collection['purchase_price'];
                    $productData->tax = $collection['tax'];
                    $productData->discount = $collection['discount'];
                    $productData->discount_type = $collection['discount_type'];
                    $productData->current_stock = $collection['current_stock'];
                    $update = $productData->save();
                    if ($update) {
                        $updatedProduct[] = $productData->id;
                    }
                } catch (\Exception $exception) {
                    \Log::error("product bulk update: " . $exception->getMessage());
                }
            }
        }
        //dd($updatedProduct);
        $products = Product::whereIn('id', $updatedProduct)->get();


        Toastr::success(count($updatedProduct) . ' - Products Updated successfully!');
        return back();
    }
}