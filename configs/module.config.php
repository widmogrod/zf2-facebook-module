<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'facebook' => 'Facebook',
            ),

            'facebook' => array(
                'parameters' => array(
                    'config' => array(
                        'appId'  => 'your_app_id',
                        'secret' => 'your_secret',
                    )
                )
            ),
        ),
    ),
);
