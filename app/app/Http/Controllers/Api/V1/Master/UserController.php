<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

final class UserController
{
    public function index(Request $request)
    {
        $type = strtolower($request->input('type', 'pagination'));

        $users = User::query()->orderBy('created_at', 'DESC');
        if ($type !== 'pagination') {
            return UserResource::collection($users->get());
        }

        $per_page = $request->input('per_page', 10);
        return UserResource::collection($users->paginate($per_page));
    }
}
