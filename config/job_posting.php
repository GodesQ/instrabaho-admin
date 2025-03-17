<?php

return [
    'max_distance' => 10000,
    'top_workers_count' => 10,
    'scoring_weights' => [
        'proximity' => 0.40,
        'availability' => 0.10,
        'skill_match' => 0.10,
        'rating' => 0.40,
    ],
];
