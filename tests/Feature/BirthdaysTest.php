<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BirthdaysTest extends TestCase
{
    use RefreshDatabase;

    public function test_contacts_with_birthdays_in_the_current_month_can_be_fetched()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create();

        $birthdayContact = Contact::factory()->create([
            'user_id' => $user->id,
            'birthday' => now()->subYear(),
        ]);

        $noBirthdayContact = Contact::factory()->create([
            'user_id' => $user->id,
            'birthday' => now()->subMonth(),
        ]);

        $this->get('/api/birthdays?api_token=' . $user->api_token)
            ->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        'contact_id' => $birthdayContact->id,
                    ]
                ]
            ]);
    }
}
