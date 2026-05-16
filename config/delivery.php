<?php

return [

    'modes' => [
        'pickup' => [
            'enabled' => true,
            'label'   => 'Click & Collect (ritiro in bottega)',
        ],
        'delivery' => [
            'enabled'             => false,
            'label'               => 'Consegna a domicilio',
            'placeholder_message' => 'La consegna a domicilio sarà disponibile prossimamente. Per ordini con consegna contattaci direttamente su WhatsApp.',
        ],
    ],

    'pickup' => [
        'days_ahead'       => 7,
        'min_hours_advance' => 2,
    ],

    'delivery' => [
        'zones' => [
            'montopoli'   => "Montopoli in Val d'Arno",
            'san_romano'  => 'San Romano',
            'le_capanne'  => 'Le Capanne',
        ],
        'cost_under_threshold' => 1.00,
        'free_threshold'       => 15.00,
    ],

    'whatsapp_number' => '393928491518',
];
