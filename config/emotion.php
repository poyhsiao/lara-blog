<?php

return [
    'available_types' => explode('|', env('EMOTION_AVAILABLE_TYPES', 'posts|comments|users')),
];
