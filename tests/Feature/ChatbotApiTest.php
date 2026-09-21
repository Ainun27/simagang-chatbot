<?php

namespace Tests\Feature;

use App\Models\KnowledgeBase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_can_answer_matching_question(): void
    {
        KnowledgeBase::create([
            'category' => 'Syarat',
            'question' => 'Apa saja syarat magang di Diskominfosantik?',
            'answer' => 'Syarat magang meliputi mahasiswa aktif D3/S1, surat pengantar kampus, dan CV.',
            'is_active' => true,
            'priority' => 10,
        ]);

        $response = $this->postJson(route('api.chatbot.send'), [
            'message' => 'apa syarat magang?',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
        ]);
        $this->assertNotEmpty($response->json('data.answer'));
    }

    public function test_chatbot_validation_fails_on_empty_message(): void
    {
        $response = $this->postJson(route('api.chatbot.send'), [
            'message' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_chatbot_returns_fallback_for_unknown_or_offtopic_query(): void
    {
        $response = $this->postJson(route('api.chatbot.send'), [
            'message' => 'mau nonton film bioskop apa yang seru ya?',
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('Maaf, saya tidak memahami maksud pertanyaan Anda', $response->json('data.answer'));
    }
}
