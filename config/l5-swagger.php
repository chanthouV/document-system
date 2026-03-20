<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Web Portal Document API',
                'description' => 'API documentation for Web Portal Document Backend',
                'version' => '1.0.0',
            ],
            'routes' => [
                /*
                 * Route for accessing api documentation interface
                */
                'api' => 'api/documentation',
            ],
            'paths' => [
                /*
                 * Path to storage directory for generated documentation
                */
                'docs' => storage_path('api'),
                /*
                 * Path to directory where to store the generated JSON documentation file
                */
                'docs_json' => 'api-docs/api-docs.json',
                /*
                 * Path to directory where to store the generated YAML documentation file
                */
                'docs_yaml' => 'api-docs/api-docs.yaml',
                /*
                 * Path to the output directory for the generated swagger UI files
                */
                'assets' => public_path('vendor/swagger-ui'),
            ],
            /*
             * API security definitions. Will be generated into documentation file.
            */
            'security' => [
                /*
                 * Examples of security definitions
                */
                /*
                'BearerAuth' => [
                    'type' => 'apiKey',
                    'name' => 'Authorization',
                    'in' => 'header',
                ],
                */
            ],
            /*
             * Generate automatically a list of resources from model annotations
            */
            'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
            /*
             * Generate automatically a list of resources from model annotations
            */
            'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),

            /*
             * Set security to Bearer token
             */
            'bearer_auth' => env('L5_SWAGGER_BEARER_AUTH', false),

            /*
             * Set security to api key authentication
             */
            'api_key_auth' => env('L5_SWAGGER_API_KEY_AUTH', false),

            /*
             * Set security to basic authentication
             */
            'basic_auth' => env('L5_SWAGGER_BASIC_AUTH', false),

            /*
             * Define constants for non-existing classes which will be replaced with
             * FQCN during parsing
            */
            'constants' => [
                'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://my-default-host.com'),
            ],

            /*
             * Swagger scanner configurations, can easily be overridden by
             * `L5Swagger\scan` options.
            */
            'scanner' => [
                /*
                 * Path to directory containing the swagger annotations
                */
                'paths' => [
                    base_path('app'),
                ],
                /*
                 * Exclude directories from scanning
                */
                'exclude' => [
                    'tests',
                    'database',
                    'storage',
                    'bootstrap',
                    'config',
                    'vendor',
                    'public',
                    'routes',
                ],
            ],

            /*
             * Additional configuration for swagger-ui
            */
            'ui' => [
                /*
                 * Disable swagger-ui
                 */
                'disable' => false,
                /*
                 * OAuth2 configuration
                 */
                'oauth2' => [
                    /*
                     * Default OAuth2 configuration
                     */
                    'default' => [
                        'client_id' => env('L5_SWAGGER_OAUTH2_CLIENT_ID', null),
                        'client_secret' => env('L5_SWAGGER_OAUTH2_CLIENT_SECRET', null),
                        'realm' => env('L5_SWAGGER_OAUTH2_REALM', null),
                        'app_name' => env('L5_SWAGGER_OAUTH2_APP_NAME', null),
                        'scope_separator' => env('L5_SWAGGER_OAUTH2_SCOPE_SEPARATOR', ' '),
                        'additional_query_string_params' => env('L5_SWAGGER_OAUTH2_ADDITIONAL_QUERY_STRING_PARAMS', null),
                    ],
                ],
                /*
                 * Additional parameters for swagger-ui
                 */
                'validator_url' => null,
                'deep_linking' => true,
                'display_operation_id' => false,
                'doc_expansion' => 'none',
                'default_models_expand_depth' => 1,
                'default_model_expand_depth' => 1,
                'default_model_rendering' => 'example',
                'display_request_duration' => false,
                'filter' => true,
                'show_extensions' => false,
                'show_common_extensions' => false,
                'try_it_out_enabled' => true,
            ],

            /*
             * API version and other configurations
            */
            'versions' => [
                'v1' => [
                    'paths' => [
                        base_path('app'),
                    ],
                ],
            ],

            /*
             * Proxy configuration
            */
            'proxy' => false,

            /*
             * Additional config for swagger-ui
            */
            'additional_config_url' => null,

            /*
             * Operations sort order
            */
            'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),

            /*
             * Validator url
            */
            'validator_url' => null,

            /*
             * Basic auth configuration
            */
            'basic_auth' => [
                'username' => env('L5_SWAGGER_BASIC_AUTH_USERNAME', null),
                'password' => env('L5_SWAGGER_BASIC_AUTH_PASSWORD', null),
            ],
        ],
    ],
];
