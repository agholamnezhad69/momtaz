<?php

namespace ali\RolePermissions\Models;


class Permission extends \Spatie\Permission\Models\Permission
{

    const PERMISSION_MANAGE_CATEGORIES = "manage categories";
    const PERMISSION_MANAGE_ROLE_PERMISSION = "manage role_permissions";
    const PERMISSION_MANAGE_COURSES = "manage courses";
    const PERMISSION_MANAGE_OWN_COURSES = "manage own courses";
    const PERMISSION_TEACH = "teach";
    const PERMISSION_SUPER_ADMIN = "super admin";
    const PERMISSION_MANAGE_USERS = "manage users";
    const PERMISSION_MANAGE_PAYMENTS = "manage payments";
    const PERMISSION_MANAGE_SETTLEMENT = "manage settlement";
    const PERMISSION_MANAGE_DISCOUNT = "manage discount";
    const PERMISSION_MANAGE_TICKETS = "manage tickets";
    const PERMISSION_MANAGE_COMMENTS = "manage comments";
    const PERMISSION_MANAGE_SLIDES = "manage slides";

    static $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_TEACH,
        self::PERMISSION_MANAGE_CATEGORIES,
        self::PERMISSION_MANAGE_ROLE_PERMISSION,
        self::PERMISSION_MANAGE_COURSES,
        self::PERMISSION_MANAGE_OWN_COURSES,
        self::PERMISSION_MANAGE_USERS,
        self::PERMISSION_MANAGE_PAYMENTS,
        self::PERMISSION_MANAGE_SETTLEMENT,
        self::PERMISSION_MANAGE_DISCOUNT,
        self::PERMISSION_MANAGE_TICKETS,
        self::PERMISSION_MANAGE_COMMENTS,
        self::PERMISSION_MANAGE_SLIDES
    ];


}
