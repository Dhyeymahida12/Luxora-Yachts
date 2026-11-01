<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_is_redirected_to_login_from_the_account_page(): void
    {
        $this->get(route('account'))
            ->assertRedirect(route('login'));
    }

    public function test_a_signed_in_user_only_sees_their_own_enquiries(): void
    {
        $member = User::factory()->create(['name' => 'Avery Morgan']);
        $otherMember = User::factory()->create();

        ContactEnquiry::create([
            'user_id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
            'service' => 'build',
            'message' => 'Design a custom yacht.',
        ]);
        ContactEnquiry::create([
            'user_id' => $otherMember->id,
            'name' => $otherMember->name,
            'email' => $otherMember->email,
            'service' => 'buy',
            'message' => 'Private enquiry from another account.',
        ]);

        $this->actingAs($member)
            ->get(route('account'))
            ->assertOk()
            ->assertSee('Design a custom yacht.')
            ->assertDontSee('Private enquiry from another account.');
    }

    public function test_account_page_escapes_user_and_enquiry_text(): void
    {
        $member = User::factory()->create([
            'name' => "Avery <script>alert('name')</script>",
        ]);
        ContactEnquiry::create([
            'user_id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
            'message' => '<img src=x onerror=alert(1)>',
        ]);

        $this->actingAs($member)
            ->get(route('account'))
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee("<script>alert('name')</script>", false)
            ->assertDontSee('<img src=x onerror=', false);
    }
}
