protected $middlewareGroups = [
    'web' => [
        // ... otros middleware
        \App\Http\Middleware\AuditoriaMiddleware::class,
    ],

    'api' => [
        // ... otros middleware
        \App\Http\Middleware\AuditoriaMiddleware::class,
    ],
];