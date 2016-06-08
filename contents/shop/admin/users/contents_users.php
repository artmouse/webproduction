<?php
Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-autocomplete', array(
    'url' => '/admin/shop/users/autocomplete/',
    'filehtml' => dirname(__FILE__).'/users_autocomplete.html',
    'filephp' => dirname(__FILE__).'/users_autocomplete.php',
    'level' => '2',
    'role' => array('users'),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-json-autocomplete', array(
    'url' => '/admin/shop/users/jsonautocomplete/',
    'filephp' => dirname(__FILE__).'/users_json_autocomplete.php',
    'level' => '2',
    'role' => array('users'),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-json-autocomplete-select2', array(
    'url' => '/admin/shop/users/jsonautocomplete/select2/',
    'filephp' => dirname(__FILE__).'/users_json_autocomplete_select2.php',
    'level' => '2',
    'role' => array('users'),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-autocomplete-select2', array(
    'url' => '/admin/shop/users/ajax/autocomplete/select2/',
    'filephp' => dirname(__FILE__).'/users_ajax_autocomplete_select2.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-autocomplete-custom-field-select2', array(
        'url' => '/admin/shop/users/ajax/autocomplete/custom/field/select2/',
        'filephp' => dirname(__FILE__).'/users_ajax_autocomplete_custom_field_select2.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-phone-ajax-autocomplete-select2', array(
    'url' => '/admin/shop/users/phone/ajax/autocomplete/select2/',
    'filephp' => dirname(__FILE__).'/users_phone_ajax_autocomplete_select2.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-info', array(
    'url' => '/admin/shop/users/ajax/info/',
    'filehtml' => dirname(__FILE__).'/users_ajax_info.html',
    'filephp' => dirname(__FILE__).'/users_ajax_info.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-search-dublicates-name', array(
    'url' => '/admin/shop/users/search/dublicates/name/',
    'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_name.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-search-dublicates-namesurname', array(
    'url' => '/admin/shop/users/search/dublicates/namesurname/',
    'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_namesurname.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-search-dublicates-email', array(
    'url' => '/admin/shop/users/search/dublicates/email/',
    'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_email.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-search-dublicates-phone', array(
    'url' => '/admin/shop/users/search/dublicates/phone/',
    'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_phone.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-contact-preview', array(
    'url' => '/admin/contact/preview/',
    'filehtml' => dirname(__FILE__).'/user_contact_preview.html',
    'filephp' => dirname(__FILE__).'/user_contact_preview.php',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'user-permission-json', array(
    'url' => '/user/permission/json/',
    'filephp' => dirname(__FILE__).'/user_permission_json.php',
    'level' => '3',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-post-autocomplete', array(
    'url' => '/admin/shop/users/ajax/post/autocomplete/',
    'filephp' => dirname(__FILE__).'/users_ajax_post_autocomplete.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-post-autocomplete', array(
    'url' => '/admin/shop/users/ajax/post/autocomplete/',
    'filephp' => dirname(__FILE__).'/users_ajax_post_autocomplete.php',
    ), 'override'
);


Engine::GetContentDataSource()->registerContent(
    'shop-admin-users-ajax-autocomplete-event-filter', array(
    'url' => '/admin/shop/users/ajax/autocomplete/event/filter/',
    'filephp' => dirname(__FILE__).'/users_ajax_autocomplete_event_filter.php',
    ), 'override'
);