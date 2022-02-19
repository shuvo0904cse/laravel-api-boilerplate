<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerifyUserController;
use App\Http\Controllers\Email\ContactController;
use App\Http\Controllers\Email\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware(['localization', 'cors', 'json.response'])->group(function () {
    //Auth
    Route::post('login', LoginController::class)->name("login");
    Route::post('register', RegistrationController::class)->name("registration");
    Route::post('forgot-password', ForgotPasswordController::class)->name("forgot.password");
    Route::post('reset-password', ResetPasswordController::class)->name("reset.password");
    Route::post('verify-user', VerifyUserController::class)->name("verify.user");

    Route::prefix('')->middleware(['auth:api'])->group(function () {
        //Role
        Route::get('roles', [RoleController::class, 'index'])->name("role.index");
        Route::post('roles', [RoleController::class, 'store'])->name("role.store");
        Route::put('roles/{role}', [RoleController::class, 'update'])->name("role.update");
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name("role.delete");
        Route::post('roles/permission/{role}', [RoleController::class, 'permission'])->name("role.permission");

        //Permission
        Route::get('permissions', [PermissionController::class, 'index'])->name("permission.index");
        Route::post('permissions', [PermissionController::class, 'store'])->name("permission.store");
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name("permission.update");
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name("permission.delete");

        //User
        Route::get('users', [UserController::class, 'index'])->name("user.index");
        Route::post('users', [UserController::class, 'store'])->name("user.store");
        Route::put('users/{user}', [UserController::class, 'update'])->name("user.update");
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name("user.delete");
        Route::post('users/permission/{user}', [UserController::class, 'permission'])->name("user.permission");

        //Contact

        //Email

        //Subscription
        Route::get('subscriptions', [SubscriptionController::class, 'index'])->name("subscriptions.index");
        Route::put('subscriptions/{subscription}', [UserController::class, 'update'])->name("subscriptions.update");
        Route::delete('subscriptions/{subscription}', [UserController::class, 'destroy'])->name("subscriptions.delete");
    });

     //Contact
     Route::post('contact', [ContactController::class, 'contact'])->name("subscribe");

     //Subscription
     Route::post('subscribe', [SubscriptionController::class, 'subscribe'])->name("subscribe");
     Route::post('un-subscribe', [UserController::class, 'unSubscribe'])->name("un.subscribe");
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
