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

Route::get('/', [HomeController::class, 'index'])->middleware(['auth']);
Route::get('/setup
', function () {
    return view('pages.setup');
})->middleware(['auth'])
    ->name('setup');
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::get('/members', [MembersController::class, 'index'])->middleware(['auth'])->name('members');
Route::get('/members-data', [MembersController::class, 'data'])->middleware(['auth'])->name('members.data');
//get member by id
Route::get('/members/{id}', [MembersController::class, 'show'])->middleware(['auth'])->name('members.show');
//delete member
Route::delete('/members-del/{id}', [MembersController::class, 'destroy'])->middleware(['auth'])->name('members.destroy');

Route::post('/add-tree', [FamilyTreeController::class, 'store'])->middleware(['auth'])->name('add-tree');
//add member
Route::post('/add-member', [MembersController::class, 'store'])->middleware(['auth'])->name('add-member');
//edit member by id
Route::post('/members-edit/{id}', [MembersController::class, 'edit'])->middleware(['auth'])->name('members.edit');
// Route::post('/login', [HomeController::class,'store']);
require __DIR__ . '/auth.php';
