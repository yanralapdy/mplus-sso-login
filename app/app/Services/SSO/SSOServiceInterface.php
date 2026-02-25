<?php

namespace App\Services\SSO;

interface SSOServiceInterface
{
    public function verify(string $token): array;
}
