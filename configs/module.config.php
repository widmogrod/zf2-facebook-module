<?php
return array(

    /*
     * User configuration layout
     */
    'FacebookBundle' => array(
        'setAppIdInHeadScript' => true,
        'appId'                => 'your_app_id',
        'secret'               => 'your_secret',
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'facebook' => 'Facebook',
            ),
        ),
    ),
);
