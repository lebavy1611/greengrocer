<?php
return [
    'domain' => 'http://greengrocer.herokuapp.com',
    'images_path_shops' => '/images/shops/',
    'images_path_categories' => '/images/categories/',
    'images_path_users' => '/images/users/',
    'images_path_promotions' => '/images/promotions/',
    'product' => [
      'images_path_products' => '/images/products/',
    ],
    'no_image' => '/images/no-image.jpg',
    'limit_rows' => 4,
    'login' => [
      'unauthorised' => 'Unauthorized',
      'success' => 'You have login successfully!'
    ],
    'limit_row_slide' => 8,
    'order' => [
      'limit_rows' => 5,
    ],
    'no_authorization' => 'Xin lỗi! Bạn chưa được cấp quyền cho thao tác này.',
    'admin_role_resources' => [
      ["resource_id"=> 1],
      ["resource_id"=> 11],
      ["resource_id"=> 21],
      ["resource_id"=> 31],
      ["resource_id"=> 41],
      ["resource_id"=> 51],
      ["resource_id"=> 61],
      ["resource_id"=> 71],
      ["resource_id"=> 81],
      ["resource_id"=> 91],
    ],
    'provider_role_resources' => [
      [
        "resource_id" => 1,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 0,
        "can_del" => 0
      ],
      [
        "resource_id" => 11,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 21,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 31,
        "can_view" => 1,
        "can_add" => 0,
        "can_edit" => 0,
        "can_del" => 0
      ],
      [
        "resource_id" => 41,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 51,
        "can_view" => 1,
        "can_add" => 0,
        "can_edit" => 1,
        "can_del" => 0
      ],
      [
        "resource_id" => 61,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 71,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 81,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
      [
        "resource_id" => 91,
        "can_view" => 1,
        "can_add" => 1,
        "can_edit" => 1,
        "can_del" => 1
      ],
    ]
];
