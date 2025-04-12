<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupAdminController;
use App\Http\Controllers\GroupMessageController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);

Broadcast::routes(['middleware' => ['auth:api']]);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/all-users', [AuthController::class,'getUsers']);
    // Route::post('broadcasting/auth', [AuthController::class, 'authorize']);
    Route::post('/broadcasting/auth', function (Request $request) {
        return Broadcast::auth($request);
    });

    Route::post('/messages', [MessageController::class, 'send']);
    Route::get('/message-convo/{userId}', [MessageController::class, 'getConversation']);
    Route::get('/messages', [MessageController::class, 'fetch']);
    Route::post('/message-send', [MessageController::class, 'sendMessage']);


    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'createGroup']);
    Route::post('/groups/{groupId}/add-member', [GroupController::class, 'addMember']);
    Route::get('/groups/{groupId}/members', [GroupController::class, 'getGroupMembers']);
    Route::delete('/groups/{groupId}/leave', [GroupController::class, 'leaveGroup']);

    // Group Messaging Routes
    Route::post('/groups/{groupId}/messages', [GroupMessageController::class, 'sendMessage']);
    Route::get('/groups/{groupId}/messages', [GroupMessageController::class, 'getMessages']);

    // Group Admin Routes
    Route::post('/groups/{groupId}/admin/{userId}', [GroupAdminController::class, 'makeAdmin']);
    Route::delete('/groups/{groupId}/remove/{userId}', [GroupAdminController::class, 'removeMember']);
    Route::delete('/groups/{groupId}', [GroupAdminController::class, 'deleteGroup']);

});
