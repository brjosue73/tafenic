<?php

return array(
    'pdf' => array(
        'enabled' => true,
        //'binary'  => '/usr/local/bin/wkhtmltopdf',
        //'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        //'binary' => base_path('vendor/wemersonjanuario/wkhtmltopdf-windows/bin/64bit/wkhtmltopdf'),
	'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),


        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        //'binary'  => '/usr/local/bin/wkhtmltoimage',
        'binary' => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
        //'binary' => base_path('vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage'),


        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
);
