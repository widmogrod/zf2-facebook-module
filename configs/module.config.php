<?php
return array(

    /*
     * User configuration layout
     */
    'FacebookBundle' => array(
        'setAppIdInHeadScript' => true,
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'facebook' => 'Facebook',
            ),
            'Facebook' => array(
                'parameters' => array(
                    'config'  => array(
                        /**
                         * Facebook PHP SDK parameters 
                         */
                        'appId'  => 'your_app_id',
                        'secret' => 'your_secret',
                    ),
                ),
            ),
        ),
    ),
);
