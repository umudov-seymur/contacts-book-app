<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function test_an_unauthenticated_user_should_redirected_to_login()
    {
        $response = $this->post('/api/contacts', $this->data('api_token'));

        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    public function data($key = null)
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'example@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
            'api_token' => $this->user->api_token
        ];

        if (!is_null($key)) {
            $data[$key] = '';
        }

        return $data;
    }

    public function test_an_authenticated_user_can_add_a_contact()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        // dd($response->getContent());

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('example@email.com', $contact->email);
        $this->assertEquals('05-14-1988', $contact->birthday->format('m-d-Y'));
        $this->assertEquals('ABC String', $contact->company);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
            ]
        ]);
    }

    public function test_a_list_of_contacts_can_be_fetched_for_the_authenticated_user()
    {
        // $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $anotherContact = Contact::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/contacts?api_token=' . $user->api_token);

        $response->assertJsonCount(1)->assertJson([
            'data' => [
                ['contact_id' => $contact->id]
            ]
        ]);
    }

    public function test_fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])->each(function ($field) {
            $response = $this->post('/api/contacts', $this->data($field));

            $response->assertSessionHasErrors($field);
            $this->assertCount(0, Contact::all());
        });
    }

    public function test_email_must_be_a_valid_email()
    {
        $response = $this->post(
            '/api/contacts',
            array_merge($this->data(), ['email' => 'NOT_VALID_EMAIL'])
        );

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    public function test_birthday_are_properly_stored()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post(
            '/api/contacts',
            $this->data()
        );

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
    }

    public function test_a_contact_can_be_retrieved()
    {
        $contact = Contact::factory([
            'user_id' => $this->user->id
        ])->create();

        $response = $this->get("/api/contacts/$contact->id?api_token=" . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);
    }

    public function test_only_the_users_contacts_can_be_retrieved()
    {
        $contact = Contact::factory([
            'user_id' => $this->user->id
        ])->create();

        $anotherUser = User::factory()->create();

        $response = $this->get("/api/contacts/$contact->id?api_token=" . $anotherUser->api_token);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_a_contact_can_be_patched()
    {
        $contact = Contact::factory([
            'user_id' => $this->user->id
        ])->create();

        $response = $this->patch("/api/contacts/$contact->id", $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('example@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);
    }

    public function test_only_the_owned_of_the_contact_can_patch_the_contact()
    {
        $contact = Contact::factory()->create();
        $anotherUser = User::factory()->create();

        $response = $this->patch(
            "/api/contacts/$contact->id",
            array_merge($this->data(), [
                'api_token' => $anotherUser->api_token
            ])
        );

        $response->assertStatus(403);
    }

    public function test_a_contact_can_be_deleted()
    {
        $contact = Contact::factory([
            'user_id' => $this->user->id
        ])->create();

        $response = $this->delete(
            "/api/contacts/$contact->id",
            ['api_token' => $this->user->api_token]
        );

        $this->assertCount(0, Contact::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_only_the_owner_can_delete_contact()
    {
        $contact = Contact::factory()->create();
        $anotherUser = User::factory()->create();

        $response = $this->delete(
            "/api/contacts/$contact->id",
            ['api_token' => $anotherUser->api_token]
        );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
}
