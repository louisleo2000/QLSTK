<?php

use App\Http\Controllers\FamilyTreeController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\Pages\HomeController;
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
    return view('pages.home');
})->middleware(['auth']);
Route::get('/setup
', function () {
    return view('pages.setup');
})->middleware(['auth'])
    ->name('setup');
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::get('/members', [MembersController::class, 'index'])->middleware(['auth'])->name('members');
Route::get('/members-data', [MembersController::class, 'data'])->middleware(['auth'])->name('members.data');

Route::post('/add-tree', [FamilyTreeController::class, 'store'])->middleware(['auth'])->name('add-tree');
Route::post('/add-member', [MembersController::class, 'store'])->middleware(['auth'])->name('add-member');
// Route::post('/login', [HomeController::class,'store']);
require __DIR__ . '/auth.php';
