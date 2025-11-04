<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */
    'show_warnings' => false,
    'public_path' => null,

    'convert_entities' => true,

    /*
    |--------------------------------------------------------------------------
    | DomPDF Options
    |--------------------------------------------------------------------------
    */
    'options' => [

        //        'font_dir'   => storage_path('fonts'),
        //        'font_cache' => storage_path('fonts'),
        'font_dir' => public_path('fonts/'),
        'font_cache' => storage_path('fonts/'),

        'temp_dir' => sys_get_temp_dir(),

        'chroot' => realpath(base_path()),

        'enable_remote' => true,
        'allowed_remote_hosts' => null,
        'allowed_protocols' => [
            'data://' => ['rules' => []],
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',

        'default_font' => 'timesnewroman',

        'font_family' => [
            'LiberationSerif' => [
                'R' => 'LiberationSerif-Regular.ttf',
                'B' => 'LiberationSerif-Bold.ttf',
                'I' => 'LiberationSerif-Italic.ttf',
                'BI' => 'LiberationSerif-BoldItalic.ttf',
            ],
        ],

        'dpi' => 96,

        'font_height_ratio' => 1.1,

        'enable_html5_parser' => true,

        'enable_php' => false,
        'enable_javascript' => false,

        'enable_font_subsetting' => false,

        'pdf_backend' => 'CPDF',
    ],

];
