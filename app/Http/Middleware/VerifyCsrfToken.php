<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/deploy',
        'receptions/load',
        'turns/load-waiters',
        'turns/load-office',
        'turns/load-release',
        'turns/load-therapist',
        'turns/user-services',
        'search',
        'search-turn',
        'patients/change-insurance',
        'turns/count-turns',
        'medicines/add',
        'patients/national-id-check',
        'patients/mobile-check',
        'turns/calculate-services',
        'status',
        'online-users',
        'turns/add-suggestion',
        'turns/service-discount',
        'turns/add-medicines',
        'turns/delete-suggestion',
        'turns/future-status'
    ];
}
