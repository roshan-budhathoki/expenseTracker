<?php

use App\Models\Expense;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    return view('welcome');
});

Route::get('/test', function () {
    return view('form');
});

Route::post('/test', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'item' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
    ]);

    $expense = new Expense();
    $expense->name = $request->name;
    $expense->item = $request->item;
    $expense->price = $request->price;
    $expense->is_veg = $request->category;
    $expense->save();

    return redirect()->route('test');
})->name('test');

Route::get('/list-expenses', function (Request $request) {

    $data = array();
    $totalVeg = 0;
    $totalNonVeg = 0;

    $date = $request->date ?? date('Y-m-d');

    //get first day of the month
    $firstDay = date('Y-m-01', strtotime($date));

    //get last day of the month
    $lastDay = date('Y-m-t', strtotime($date));

    if (isset($request->name)) {
        $expenses = Expense::where('name', 'like', '%' . $request->name . '%')->whereBetween('created_at', [$firstDay, $lastDay])->get();

        //get total veg and non-veg expenses of the person
        $totalVeg = Expense::where('name', 'like', '%' . $request->name . '%')->whereBetween('created_at', [$firstDay, $lastDay])->where('is_veg', 1)->sum('price');
        $totalNonVeg = Expense::where('name', 'like', '%' . $request->name . '%')->whereBetween('created_at', [$firstDay, $lastDay])->where('is_veg', 0)->sum('price');

        array_push($data, $expenses);
    }

    if (isset($request->veg)) {
        $expenses = Expense::where('is_veg', $request->veg)->whereBetween('created_at', [$firstDay, $lastDay])->get();
        array_push($data, $expenses);
    }

    if (isset($request->date)) {
        // example of date format: 2023-01-10
        $expenses = Expense::whereBetween('created_at', [$firstDay, $lastDay])->get();
        array_push($data, $expenses);
    }

    // if no filter is applied
    if (!isset($request->name) && !isset($request->veg) && !isset($request->date)) {
        $expenses = Expense::whereBetween('created_at', [$firstDay, $lastDay])->get();
        $totalVeg = Expense::whereBetween('created_at', [$firstDay, $lastDay])->where('is_veg', 1)->sum('price');
        $totalNonVeg = Expense::whereBetween('created_at', [$firstDay, $lastDay])->where('is_veg', 0)->sum('price');
        array_push($data, $expenses);
    }

    $finalData = $data[0];
    return response()->json([
        'expenses' => $finalData,
        'totalVeg' => $totalVeg,
        'totalNonVeg' => $totalNonVeg,
    ]);
});
