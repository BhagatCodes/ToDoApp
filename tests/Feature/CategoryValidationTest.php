<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryValidationTest extends TestCase
{
    public function test_invalid_category_submission_does_not_open_task_modal(): void
    {
        $response = $this->from('/')->post('/addCategory', [
            'category-title' => 'ab',
        ]);

        $response->assertSessionHasErrors(['category-title']);

        $this->get('/')->assertOk()->assertDontSee("modal.setAttribute('aria-hidden', 'false');");
    }
}
