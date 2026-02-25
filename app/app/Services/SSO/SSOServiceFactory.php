<?php

namespace App\Services\SSO;

use App\Enums\SSOLoginProviderEnum;

class SSOServiceFactory
{
    public static function make(SSOLoginProviderEnum $provider): SSOServiceInterface
    {
        return match ($provider) {
            SSOLoginProviderEnum::GOOGLE => app(SSOGoogleService::class),
            SSOLoginProviderEnum::FACEBOOK => app(SSOFacebookService::class),
        };
    }
}
