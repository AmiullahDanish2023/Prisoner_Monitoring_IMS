<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General mPDF Settings
    |--------------------------------------------------------------------------
    */

    'mode' => 'utf-8',

    // Paper size (replaces setPaper)
    'format' => 'A4',

    // Default orientation: P = Portrait, L = Landscape
    'orientation' => 'P',

    'author' => 'Wahidullah Hashami',
    'subject' => 'Generate Report into PDF',
    'keywords' => 'PDF, Laravel, mPDF, Report',
    'creator' => 'Laravel mPDF',

    'display_mode' => 'fullpage',

    /*
    |--------------------------------------------------------------------------
    | Temporary directory (IMPORTANT)
    |--------------------------------------------------------------------------
    */

    'tempDir' => storage_path('app/mpdf'),

    /*
    |--------------------------------------------------------------------------
    | PDF/A (keep disabled unless required)
    |--------------------------------------------------------------------------
    */

    'pdf_a' => false,
    'pdf_a_auto' => false,
    'icc_profile_path' => '',

    /*
    |--------------------------------------------------------------------------
    | RTL & Language Support
    |--------------------------------------------------------------------------
    */

    'autoScriptToLang' => true,
    'autoLangToFont' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Font
    |--------------------------------------------------------------------------
    */

    'default_font' => 'bahijfont',

    /*
    |--------------------------------------------------------------------------
    | Custom Fonts
    |--------------------------------------------------------------------------
    */

    'font_path' => public_path('assets/fonts'),

    'font_data' => [
        'bahijfont' => [
            'R' => 'bahij-nazanin.ttf',   // Regular
            'B' => 'bahij-nazanin.ttf',   // Bold (optional)
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Margins
    |--------------------------------------------------------------------------
    */

    'margin_left'   => 10,
    'margin_right'  => 10,
    'margin_top'    => 15,
    'margin_bottom' => 15,

];
