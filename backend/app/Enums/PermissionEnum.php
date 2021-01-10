<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermissionEnum extends Enum
{
    public const GET_PREMIUM_POSTS_PERMISSION = 'get premium posts';
    public const MANAGE_PROFILE_PERMISSION = 'manage-profile';
}
