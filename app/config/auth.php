<?php

return array(

    'multi' => array(
        'user' => array(
            'email' => 'emails.auth.reminder',
            'driver' => 'Eloquent',
            'model' => 'Usuarios'
        )
    ),

    'reminder' => array(

        'email' => 'emails.auth.reminder',

        'table' => 'password_reminders',

        'expire' => 60,

    ),

);
