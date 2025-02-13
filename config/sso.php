<?php
return [
    // This secret must match the one in System A
    'shared_logout_secret' => env('SSO_LOGOUT_SECRET', 'your-very-secret-key'),
];
