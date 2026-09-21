<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluasiChatbotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\KnowledgeBaseSeeder::class);
    }

    public function test_can_render_evaluasi_chatbot_page(): void
    {
        $response = $this->get('/evaluasi-chatbot');

        $response->assertStatus(200);
        $response->assertSee('AI Evaluation Lab');
        $response->assertSee('Tingkat Akurasi');
        $response->assertSee('Confusion Matrix');
        $response->assertSee('Natural Language Processing');
    }

    public function test_can_run_automated_benchmark_ajax(): void
    {
        $response = $this->postJson('/evaluasi-chatbot/run-benchmark');

        $response->assertStatus(200);
        $data = $response->json('data');
        
        // Print summary to console for audit
        fwrite(STDERR, "\n--- BENCHMARK RESULTS ---\n");
        fwrite(STDERR, "Total Tests : " . $data['total_tests'] . "\n");
        fwrite(STDERR, "Correct     : " . $data['total_correct'] . "\n");
        fwrite(STDERR, "Accuracy    : " . $data['accuracy'] . "%\n");
        fwrite(STDERR, "Precision   : " . $data['precision'] . "%\n");
        fwrite(STDERR, "Recall      : " . $data['recall'] . "%\n");
        fwrite(STDERR, "F1-Score    : " . $data['f1_score'] . "%\n");
        fwrite(STDERR, "Avg Latency : " . $data['avg_latency_ms'] . " ms\n");
        fwrite(STDERR, "Confusion Matrix: TP=" . $data['confusion_matrix']['tp'] . " TN=" . $data['confusion_matrix']['tn'] . " FP=" . $data['confusion_matrix']['fp'] . " FN=" . $data['confusion_matrix']['fn'] . "\n");

        foreach ($data['details'] as $item) {
            if (!$item['is_correct']) {
                fwrite(STDERR, "MISSED [#" . $item['id'] . "] (" . $item['category_type'] . "): '" . $item['question'] . "' -> Bot: " . $item['bot_status'] . " (Conf: " . $item['confidence'] . "%)\n");
            }
        }
        fwrite(STDERR, "-------------------------\n");

        $response->assertJsonStructure([
            'status',
            'data' => [
                'total_tests',
                'total_correct',
                'accuracy',
                'precision',
                'recall',
                'f1_score',
                'avg_latency_ms',
                'confusion_matrix' => [
                    'tp', 'fp', 'fn', 'tn'
                ],
                'details'
            ]
        ]);
    }

    public function test_can_test_single_query_via_inspector(): void
    {
        $response = $this->postJson('/evaluasi-chatbot/test-single', [
            'question' => 'apa saja syarat daftar magang disini?'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'query',
            'bot_status',
            'bot_category',
            'matched_question',
            'confidence',
            'latency_ms',
            'tokens',
            'keywords',
            'bot_answer'
        ]);
    }

    public function test_chatbot_can_handle_conversational_greetings_and_thanks(): void
    {
        $service = app(\App\Services\ChatbotService::class);

        // 1. Test Sapaan "halo"
        $haloRes = $service->getResponse('halo');
        $this->assertEquals('success', $haloRes['status']);
        $this->assertEquals('Sapaan & Bantuan', $haloRes['category']);

        // 2. Test Sapaan "hai min"
        $haiRes = $service->getResponse('hai min');
        $this->assertEquals('success', $haiRes['status']);

        // 3. Test Terima Kasih "terima kasih banyak"
        $thanksRes = $service->getResponse('terima kasih banyak');
        $this->assertEquals('success', $thanksRes['status']);
        $this->assertEquals('Ucapan Terima Kasih', $thanksRes['category']);

        // 4. Test Identitas Bot "kamu siapa"
        $whoRes = $service->getResponse('kamu siapa');
        $this->assertEquals('success', $whoRes['status']);
        $this->assertEquals('Profil & Identitas Bot', $whoRes['category']);
    }
}
