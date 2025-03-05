<?php

return [
    'max_distance' => 10000,
    'top_workers_count' => 10,
    'scoring_weights' => [
        'proximity' => 0.35,
        'availability' => 0.25,
        'skill_match' => 0.20,
        'rating' => 0.20,
    ],
];
