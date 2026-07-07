<?php

use app\Http\Controllers\CommentController;
use app\Http\Controllers\FollowController;
use app\Http\Controllers\GoogleAuthController;
use app\Http\Controllers\LikeController;
use app\Http\Controllers\PostController;
use app\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", function() {
    return view("index");
});

Route::prefix("/auth")->group(function() {
    Route::post("/login", [UserContoller::class, "login"]);
    Route::post("/register", [UserContoller::class, "register"]);

    Route::middleware("/auth.sanctum")->group(function() {
        Route::post("/logout", [UserController::class, "logout"]);
        Route::get("/user", [UserController::class, "setUserDetails"]);
        Route::post("/setPassword", [UserController::class, "setPassword"]);
    });

    Route::post("/InitReset", [UserController::class, "initResetPassword"]);
    Route::get("/ViewReset", [UserController::class, "resetPasswordView"])->name("resetPasswordView");
    Route::post("/PassReset", [UserController::class, "resetPasword"]);

    Route::post("/ConfirmEmail", [UserController::class, "setConfirmEmail"])->name("setConfirmEmail");

    Route::get("/redirect/google", [GoogleAuthController::class, "redirect"]);
    Route::get("/callback/google", [GoogleAuthController::class, "callback"]);
});

Route::prefix("/api")->group(function() {

    Route::prefix("/post")->group(function() {
        Route::get("/", [PostController::class, "getPost"]);
        Route::post("/", [PostController::class, "createPost"])->middleware("/auth:sanctum");
        Route::put("/{id}", [PostController::class, "updatePost"]);
        Route::delete("/{id}", [PostController::class, "deletePost"]);
        Route::get("/coments", [PostController::class, "getComments"]);
    });

    Route::prefix("/likes")->group(function() {
        Route::post("/", [LikeController::class, "createLike"]);
        Route::delete("/{id}", [LikeController::class, "deleteLike"]);
    });

    Route::prefix("/comments")->group(function() {
        Route::post("/", [CommentController::class, "createComment"]);
        Route::put("/{id}", [CommentController::class, "updateComment"]);
        Route::delete("/{id}", [CommentController::class, "deleteComment"]);
    });

    Route::prefix("/follows")->group(function() {
        Route::get("/", [FollowController::class, "getFollows"]);
        Route::post("/", [FollowController::class, "createFollows"]);
        Route::get("/following/{toUser}", [FollowController::class, "getFollow"]);
        Route::delete("/{id}", [FollowController::class, "deleteFollow"]);
    });

    Route::prefix("/user")->middleware("/auth:sanctum")->group(function() {
        Route::post("/avatar", [UserController::class, "setAvatar"]);
        Route::post("/banner", [UserController::class, "setBanner"]);
        Route::post("/description", [UserController::class, "setDescription"]);
    });
});