<?php
return array(

    /*
     * Is not required IF 'di->instance->facebook' config section is set.
     * User configuration layout will be propagated to 'di->instance->facebook' IF 'di->instance->facebook->config' is not set.
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

            /*
             * Is not required, IF 'FacebookBundle' config section is set.
             */
            'facebook' => array(
                'config' => array(
                    'appId'                => 'your_app_id',
                    'secret'               => 'your_secret',
                )
            )
        ),
    ),
);
