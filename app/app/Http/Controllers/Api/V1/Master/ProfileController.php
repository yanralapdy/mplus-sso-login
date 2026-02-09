<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Requests\Api\V1\Auth\ProfileUpdateFormRequest;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;

final class ProfileController
{
    public function show(Request $request)
    {
        return response()->json([
            'data' => new UserResource($request->user()),
        ]);
    }

    public function update(ProfileUpdateFormRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user),
        ]);
    }
}
