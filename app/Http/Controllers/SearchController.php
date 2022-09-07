<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $data = '';
        $className = '\App\Models\\'. $request->model;

        // if($request->var)
        // {
        //     if($request->model !== 'User' && $request->model !== 'Customer')
        //     {
        //         $data = $className::search($request->key)->get();
        //         if($request->val == 'ASC')
        //         {
        //             $data = $data->sortBy($request->var);
        //         }
        //         else
        //         {
        //             $data = $data->sortByDesc($request->var);
        //         }
        //     }
        // }
        // else
        // {
        //     if($request->model !== 'User' && $request->model !== 'Customer')
        //     {
        //         $data = $className::search($request->key)->get();
        //     }
        // }


        switch($request->model)
        {
            case 'Sale':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Orders', ['orders' => $data]);
                break;
            case 'Inventory':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->with('item')->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->with('item')->paginate(20);
                }
                return Inertia::render('Inventory', ['inventories' => $data, 'stores' => Store::all(), 'transfers' => Transfer::with(['destination', 'inventory.item'])->paginate(20)]);
                break;

            case 'Item':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Items',['items' => $data->paginate(20)]);
                break;

            case 'Product':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->with(['inventory.item'])->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->with(['inventory.item'])->paginate(20);
                }
                $transfers = in_array('admin', Auth::user()->roles->pluck('name')->toArray()) ? Transfer::all()->load(['destination', 'inventory']) : Transfer::whereHas('destination', function($q)
                {
                    $q->where('name',  Auth::user()->permissions[0]->name)->where('type', 'toproduct');
                })->get()->load(['destination', 'inventory']);
                
                return Inertia::render('Products',['products' => $data,'stores' => Store::all(), 'transfers' => $transfers]);
                break;

            case 'Supplier':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Suppliers', ['suppliers' => $data]);
                break;

            case 'Transaction':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Transactions', ['transactions' => $data]);
                break;

            case 'Store':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Store', ['stores' => $data]);
                break;

            case 'Purchase':
                if($request->val)
                {
                    $data = $className::where('id', 'like', "%$request->key%")->orderBy($request->var, $request->val)->paginate(20);
                }
                else
                {
                    $data = $className::where('id', 'like', "%$request->key%")->paginate(20);
                }
                return Inertia::render('Purchase', ['purchases' => $data, 'suppliers' => Supplier::all(), 'items' => Item::all()]);
                break;
            
            case 'User':
                $users = '';
                if($request->var)
                {
                    $users = User::whereHas('roles', function($q){
                        $q->where('name', 'manager')->orWhere('name', 'sales')->orWhere('name', 'admin');
                    })->where('name','like', '%'.$request->key.'%')->orderBy($request->var, $request->val)->get();
                } 
                else
                {
                    $users = User::whereHas('roles', function($q){
                        $q->where('name', 'manager')->orWhere('name', 'sales')->orWhere('name', 'admin');
                    })->where('name','like', '%'.$request->key.'%')->get();
                }                 
                return Inertia::render('Users', ['users' => $users->load('roles'), 'roles' => Role::all(), 'permissions' => Permission::all()]);
                break;

            case 'Customer':
                $users = '';
                if($request->var)
                {
                    $users = User::whereHas('roles', function($q){
                        $q->where('name', 'customer');
                    })->where('name','like', '%'.$request->key.'%')->orderBy($request->var, $request->val)->get();
                }
                else
                {
                    $users = User::whereHas('roles', function($q){
                        $q->where('name', 'customer');
                    })->where('name','like', '%'.$request->key.'%')->get();
                }

                return Inertia::render('Customers', ['users' => $users->load('roles'), 'roles' => Role::all(), 'permissions' => Permission::all()]);
                break;

        }
    }
}
