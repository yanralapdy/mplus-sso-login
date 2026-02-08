<?php

declare(strict_types=1);

namespace App\Enums;

enum SSOLoginProviderEnum: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';

    public function label(): string
    {
        return match ($this) {
            self::GOOGLE => 'Google Sign In',
            self::FACEBOOK => 'Facebook Sign In',
        };
    }
}
