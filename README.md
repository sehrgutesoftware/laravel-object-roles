# Laravel Object Roles

> Roles & Permissions for Laravel where roles can be held in regard to a database object

## Why?
There are plenty of packages that add ACL functionalities to a Laravel application. Yet, none of the existing solutions seems to allow us to assign roles to users with respect to an object. We often come across a use case where we do not only need to define global roles, such as `TECH_ADMIN`, but also roles in regard to a database object, such as an `Organisation`, which has eg. `EDITOR` users that are granted certain permissions only on that specific `Organisation` and not on others.

## Disclaimer
**This package is in its very early days. It currently makes quite a few assumptions:**

1. Users are stored in a `users` table
2. The `users` table already exists when installing the package and running the migrations
3. The `users` table has a primary key `id` which is an `unsigned integer`
4. Neither of the following tables exists before installing the package:
    - `roles`
    - `permissions`
    - `permission_role`
    - `role_user`

## Usage
### 1. Install Package
```bash
composer require sehrgut/laravel-object-roles
```

### 2. Run database migrations
```bash
php artisan migrate
```

### 3. Use `HasRolesAndPermissions` trait on the `User` model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SehrGut\LaravelObjectRoles\HasRolesAndPermissions;

class User extends Model
{
    use HasRolesAndPermissions;
}
```

## License
This project is released under the [MIT License](https://spdx.org/licenses/MIT.html).
