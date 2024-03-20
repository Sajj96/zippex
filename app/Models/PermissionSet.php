<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PermissionSet extends Model
{

    public const PERMISSIONS_LABEL  = "permissions";

    //Products
    public const PERMISSION_PRODUCT_ADD        = "PERMISSION_PRODUCT_ADD";
    public const PERMISSION_PRODUCT_EDIT       = "PERMISSION_PRODUCT_EDIT";
    public const PERMISSION_PRODUCTS_VIEW      = "PERMISSION_PRODUCTS_VIEW";
    public const PERMISSION_PRODUCT_DELETE    = "PERMISSION_PRODUCT_DELETE";

    //Product Categories
    public const PERMISSION_CATEGORY_ADD        = "PERMISSION_CATEGORY_ADD";
    public const PERMISSION_CATEGORY_EDIT       = "PERMISSION_CATEGORY_EDIT";
    public const PERMISSION_CATEGORIES_VIEW      = "PERMISSION_CATEGORIES_VIEW";
    public const PERMISSION_CATEGORY_DELETE    = "PERMISSION_CATEGORY_DELETE";

    //Users
    public const PERMISSION_USER_ADD    = "PERMISSION_USER_ADD";
    public const PERMISSION_USER_EDIT   = "PERMISSION_USER_EDIT";
    public const PERMISSION_USERS_VIEW  = "PERMISSION_USERS_VIEW";
    public const PERMISSION_USER_DELETE = "PERMISSION_USER_DELETES";

    //Orders
    public const PERMISSION_ORDER_ADD         = "PERMISSION_ORDER_ADD";
    public const PERMISSION_ORDER_EDIT        = "PERMISSION_ORDER_EDIT";
    public const PERMISSION_ORDERS_VIEW       = "PERMISSION_ORDERS_VIEW";
    public const PERMISSION_ORDERDETAILS_VIEW = "PERMISSION_ORDERDETAILS_VIEW";
    public const PERMISSION_ORDER_DELETE      = "PERMISSION_ORDER_DELETES";

    //Roles
    public const PERMISSION_ROLE_ADD    = "PERMISSION_ROLE_ADD";
    public const PERMISSION_ROLE_EDIT   = "PERMISSION_ROLE_EDIT";
    public const PERMISSION_ROLES_VIEW  = "PERMISSION_ROLES_VIEW";
    public const PERMISSION_ROLE_DELETE = "PERMISSION_ROLE_DELETE";

    //FAQ
    public const PERMISSION_FAQ_ADD    = "PERMISSION_FAQ_ADD";
    public const PERMISSION_FAQ_EDIT   = "PERMISSION_FAQ_EDIT";
    public const PERMISSION_FAQS_VIEW  = "PERMISSION_FAQS_VIEW";
    public const PERMISSION_FAQ_DELETE = "PERMISSION_FAQ_DELETE";

    //Testimonies
    public const PERMISSION_TESTIMONY_ADD     = "PERMISSION_TESTIMONY_ADD";
    public const PERMISSION_TESTIMONY_EDIT    = "PERMISSION_TESTIMONY_EDIT";
    public const PERMISSION_TESTIMONIES_VIEW   = "PERMISSION_TESTIMONIES_VIEW";
    public const PERMISSION_TESTIMONY_DELETE  = "PERMISSION_TESTIMONY_DELETE";

    //Transactions
    public const PERMISSION_TRANSACTION_ADD     = "PERMISSION_TRANSACTION_ADD";
    public const PERMISSION_TRANSACTION_EDIT    = "PERMISSION_TRANSACTION_EDIT";
    public const PERMISSION_TRANSACTIONS_VIEW   = "PERMISSION_TRANSACTIONS_VIEW";
    public const PERMISSION_TRANSACTION_DELETE  = "PERMISSION_TRANSACTION_DELETE";

    //Blog
    public const PERMISSION_BLOG_ADD     = "PERMISSION_BLOG_ADD";
    public const PERMISSION_BLOG_EDIT    = "PERMISSION_BLOG_EDIT";
    public const PERMISSION_BLOGS_VIEW   = "PERMISSION_BLOGS_VIEW";
    public const PERMISSION_BLOG_DELETE  = "PERMISSION_BLOG_DELETE";

    //Packages
    public const PERMISSION_PACKAGE_ADD     = "PERMISSION_PACKAGE_ADD";
    public const PERMISSION_PACKAGE_EDIT    = "PERMISSION_PACKAGE_EDIT";
    public const PERMISSION_PACKAGES_VIEW   = "PERMISSION_PACKAGES_VIEW";
    public const PERMISSION_PACKAGE_DELETE  = "PERMISSION_PACKAGE_DELETE";

    public static function permissions() {
        $refClass = new \ReflectionClass(static::class);
        $constantList =  $refClass->getConstants();
        $permissions = [];
        foreach ($constantList as  $key => $item) {
            if (str_contains($key, 'PERMISSION_')){
                $permissions[$key] = $item;
            }
        }
        return $permissions;
    }

    public static function permissionsGroups() {
        $refClass = new \ReflectionClass(static::class);
        $constantList =  $refClass->getConstants();
        $permissions = [];
        foreach ($constantList as  $key => $item) {
            if (str_contains($key, 'PERMISSION_')){
                $perms = explode('_', $key);
                $group = $perms[1];
                if (!isset($permissions[$group])) {
                    $permissions[$group] = [
                        'name' => $group,
                        'label' => ucwords(Str::replace('_', ' ', $group)),
                        self::PERMISSIONS_LABEL => []
                    ];
                }
                $permissions[$group][self::PERMISSIONS_LABEL][] = [
                    'pem' => $item,
                    'label' => ucwords(Str::lower(Str::replace(['PERMISSION_','_'], ' ', $item))),
                ];
            }
        }
        return $permissions;
    }
}
