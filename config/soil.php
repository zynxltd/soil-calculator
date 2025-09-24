<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Soil Density Configuration
    |--------------------------------------------------------------------------
    |
    | These values represent the density of different soil types in tonnes
    | per cubic meter. These can be overridden via environment variables.
    |
    */
    'densities' => [
        'intensive' => env('SOIL_INTENSIVE_DENSITY', 1.3),
        'extensive' => env('SOIL_EXTENSIVE_DENSITY', 1.1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Limits
    |--------------------------------------------------------------------------
    |
    | Maximum and minimum values for input validation
    |
    */
    'limits' => [
        'max_length_width' => env('SOIL_MAX_LENGTH_WIDTH', 10000),
        'max_depth' => env('SOIL_MAX_DEPTH', 100),
        'min_dimension' => env('SOIL_MIN_DIMENSION', 0.01),
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversion Constants
    |--------------------------------------------------------------------------
    |
    | Constants used for unit conversions and calculations
    |
    */
    'constants' => [
        'tonnes_to_kg' => 1000,
        'liters_per_cubic_meter' => 1000,
    ],
];
