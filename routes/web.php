<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyResepController;
use App\Http\Controllers\BMRController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/Home', function () {
        return view('Home');
    });

    Route::prefix('resep')->group(function () {
        Route::get('create-recipe', [RecipeController::class, 'createRecipe']);
        Route::get('get-recipe', [RecipeController::class, 'getRecipe'])->name('get-recipe');
        Route::get('update-recipe/{id}', [RecipeController::class, 'updateRecipe']);
        Route::get('tambah-like/{id}', [RecipeController::class, 'tambahLike']);
        Route::get('delete-recipe/{id}', [RecipeController::class, 'deleteRecipe']);
        Route::get('getByLike-recipe', [RecipeController::class, 'getRecipeByLike']);
        Route::get('getByFilter-recipe', [RecipeController::class, 'getRecipeByFilter']);
    });

    Route::prefix('user')->group(function () {
        Route::get('create-user', [UserController::class, 'createUser']);
        Route::get('get-user', [UserController::class, 'getUser'])->name('get-user');
        Route::get('update-user', [UserController::class, 'updateUser']);
        Route::get('delete-user/{id}', [UserController::class, 'deleteUser']);
    });

    Route::prefix('myresep')->group(function () {
        Route::get('get-recipe', [MyResepController::class, 'getRecipe'])->name('get-myresep');
        Route::get('create-recipe', [MyResepController::class, 'createMyResep']);
        Route::get('delete-recipe/{id}', [MyResepController::class, 'deleteRecipe']);
        Route::get('getByUserAndMyResep', [MyResepController::class, 'getRecipeByUserAndMyResep']);
        Route::get('addBookmark/{id}', [MyResepController::class, 'addBookmark']);
    });

    Route::get('/BMR', [BMRController::class, 'calculateBMR']);

    Route::post('/login', function (Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/Home');
        } else {
            return redirect('/login')->with('error', 'Email or password incorrect');
        }
    })->name('login.submit');

    Route::get('/Recipes', function () {
        return view('Recipes');
    });

    Route::get('/Calories', function () {
        return view('Calories');
    });

    Route::get('/Profil', function () {
        return view('Profil');
    });

    Route::get('/EditProfile', function () {
        return view('EditProfile');
    });

    Route::get('/MyRecipe', function () {
        return view('MyRecipe');
    });

    Route::get('/UploadRecipe', function () {
        return view('UploadRecipe');
    });

    Route::get('/DetailRecipe', function () {
        return view('DetailRecipe');
    });

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('login');
    });
});

Route::get('/', function () {
    return view('LandingPage');
});

Route::get('/SignUp', function () {
    return view('SignUp');
});

Route::get('/Login', function () {
    if (Auth::check()) {
        return redirect('/Home');
    }
    return view('Login');
})->name('login');

Route::post('/signup', [AuthController::class, 'register'])->name('register.submit');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return redirect('/Home');
    } else {
        return redirect('/login')->with('error', 'Email or password incorrect');
    }
})->name('login.submit');
