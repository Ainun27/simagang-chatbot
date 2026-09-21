<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Chatbot Configuration
    |--------------------------------------------------------------------------
    */
    
    // Threshold minimum kemiripan (0-100)
    'threshold' => env('CHATBOT_THRESHOLD', 25),
    
    // Fallback responses
    'fallback_responses' => [
        'Maaf, saya belum mengerti pertanyaan Anda. 😊 Silakan hubungi admin kami.',
        'Mohon maaf, saya belum paham. Silakan tanyakan dengan kata kunci yang lebih jelas.',
        'Pertanyaan Anda belum ada di database saya. Silakan hubungi admin kami.',
    ],
    
    // Stopwords
    'stopwords' => [
        'apa', 'bagaimana', 'siapa', 'dimana', 'kapan', 'mengapa',
        'yang', 'di', 'ke', 'dari', 'dan', 'atau', 'untuk', 'dengan',
    ],
];