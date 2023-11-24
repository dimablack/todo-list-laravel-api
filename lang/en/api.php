<?php

return [

    'auth' => [
        'forbidden' => 'You are not allow to do this.',
        'not_belongs' => 'You do not own this :object.',
        'invalid_credentials' => 'Invalid credentials.',
        'logout' => 'Logout successfully.',
    ],
    'crud' => [
        'delete' => [
            'success' => ':Object was successfully deleted.',
        ],
    ],
    'message' => [
        'deny' => [
            'status' => [
                'completed' => 'Operation deny. :Object is completed.',
                'not_completed_children' => 'Operation denied. There is at least one not completed task among the children.',
            ],
            'parent_id' => [
                'exists' => 'Operation denied. The specified parent task exists among the children.',
            ],
        ],
    ],
];
