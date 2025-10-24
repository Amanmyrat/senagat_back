<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Plugin Options
    |--------------------------------------------------------------------------
    */
    'key' => env('GMAP_API', ''),

    'default_location' => [
        'lat' => 37.94615518867592,
        'lng' => 58.36612353205565,
    ],

    'default_zoom' => 8,

    'default_draggable' => true,

    'default_clickable' => true,

    'default_height' => '400px',

    'my_location_button' => 'My location',
];
