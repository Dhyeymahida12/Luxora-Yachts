<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\YachtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_create_an_account_and_is_signed_in(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Avery Morgan',
            'email' => 'avery@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Avery Morgan',
            'email' => 'avery@example.com',
        ]);
        $this->assertTrue(Hash::check('secure-password', User::query()->where('email', 'avery@example.com')->value('password')));
    }

    public function test_a_user_can_sign_in_and_sign_out(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_invalid_credentials_do_not_sign_a_user_in(): void
    {
        User::factory()->create(['email' => 'avery@example.com']);

        $this->from(route('login'))
            ->post(route('login.authenticate'), [
                'email' => 'avery@example.com',
                'password' => 'not-the-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_all_advertised_pages_render(): void
    {
        $this->seed(YachtSeeder::class);

        foreach ([
            '/',
            '/charter',
            '/yachts',
            '/yachts/aurelia',
            '/contact',
            '/buy',
            '/build',
            '/design',
            '/destinations',
            '/sell',
            '/management',
            '/crew',
            '/about',
            '/news',
            '/careers',
            '/login',
            '/register',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_homepage_uses_its_own_yacht_hero_video(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<video', false)
            ->assertSee('videos/home-hero.mp4', false)
            ->assertSee('autoplay muted loop playsinline', false)
            ->assertDontSee('images/hero.jpg', false);

        $this->assertFileExists(public_path('videos/home-hero.mp4'));
    }

    public function test_homepage_can_use_a_hosted_hero_video_url(): void
    {
        config(['app.home_hero_video_url' => 'https://media.example.com/home-hero.mp4']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<source src="https://media.example.com/home-hero.mp4" type="video/mp4">', false);
    }

    public function test_home_and_charter_pages_include_distinct_planning_guidance(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('A GOOD FIRST STEP')
            ->assertSee('Picture the experience');

        $this->get(route('charter'))
            ->assertOk()
            ->assertSee('BEFORE YOU')
            ->assertSee('What information should I have before enquiring?')
            ->assertSee('Are the yachts in the profile directory available to charter?');
    }

    public function test_service_pages_include_page_specific_faq_guidance(): void
    {
        foreach ([
            'buy' => 'What should I decide before looking at yachts?',
            'build' => 'How do I begin planning a new build?',
            'design' => 'What is the difference between a refit and a redesign?',
            'destinations' => 'When is the best time to plan a yacht itinerary?',
            'sell' => 'What information helps prepare a yacht for sale?',
            'management' => 'What can yacht management include?',
            'crew' => 'What should I consider when hiring yacht crew?',
            'about' => 'How does Luxora approach a new client brief?',
            'news' => 'How often is the journal updated?',
            'careers' => 'What should I include in an introduction?',
        ] as $page => $question) {
            $this->get(route($page))
                ->assertOk()
                ->assertSee('GOOD QUESTIONS')
                ->assertSee($question);
        }
    }

    public function test_buy_build_and_design_pages_include_specific_planning_guidance(): void
    {
        foreach ([
            'buy' => ['Verify before you commit', 'total ownership budget', 'Look beyond the asking price.'],
            'build' => ['Select the team', 'change control', 'Keep the project buildable.'],
            'design' => ['Plan delivery', 'technical constraints', 'Balance beauty with life on board.'],
        ] as $page => [$processStep, $planningDetail, $planningTitle]) {
            $this->get(route($page))
                ->assertOk()
                ->assertSee($processStep)
                ->assertSee($planningDetail)
                ->assertSee($planningTitle)
                ->assertSee(route('contact', ['service' => $page]), false);
        }
    }

    public function test_project_briefs_use_a_separate_photo_from_the_story(): void
    {
        foreach (['buy', 'build', 'design'] as $page) {
            $content = $this->get(route($page))
                ->assertOk()
                ->getContent();

            preg_match('/<section class="experience-story">\s*<img src="([^"]+)"/', $content, $storyImage);
            preg_match('/<div class="experience-brief__image" style="background-image:url\(\'([^\']+)\'\)"><\/div>/', $content, $briefImage);

            $this->assertArrayHasKey(1, $storyImage);
            $this->assertArrayHasKey(1, $briefImage);
            $this->assertNotSame($storyImage[1], $briefImage[1]);
        }
    }

    public function test_a_visitor_can_join_the_newsletter(): void
    {
        $this->from('/')
            ->post(route('newsletter.subscribe'), [
                'newsletter_email' => 'reader@example.com',
            ])
            ->assertRedirect('/');

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => 'reader@example.com',
        ]);
    }

    public function test_charter_page_focuses_on_trip_planning_and_links_to_yacht_profiles(): void
    {
        $this->seed(YachtSeeder::class);

        $this->get(route('charter'))
            ->assertOk()
            ->assertSee('WHICH WAY IS THE WATER CALLING?')
            ->assertSee('THE MEDITERRANEAN')
            ->assertSee('THE CARIBBEAN')
            ->assertSee('Your dates')
            ->assertSee('Your guests')
            ->assertSee(route('yachts.index'), false)
            ->assertDontSee('data-charter-filters', false)
            ->assertDontSee('Aurelia');
    }

    public function test_a_yacht_enquiry_prefills_the_contact_form(): void
    {
        $this->seed(YachtSeeder::class);

        $this->get(route('contact', ['yacht' => 'Aurelia']))
            ->assertOk()
            ->assertSee('<option value="Aurelia" selected>', false)
            ->assertSee('PREFERRED START')
            ->assertSee('WEEKLY STARTING BUDGET');
    }

    public function test_a_service_enquiry_prefills_the_contact_form(): void
    {
        foreach ([
            'buy' => 'Buy a yacht',
            'build' => 'Build a yacht',
            'design' => 'Design or refit',
        ] as $service => $label) {
            $this->get(route('contact', ['service' => $service]))
                ->assertOk()
                ->assertSee('<option value="'.$service.'" selected>'.$label.'</option>', false);
        }
    }

    public function test_a_contact_enquiry_is_saved(): void
    {
        $this->seed(YachtSeeder::class);

        $this->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => 'Avery Morgan',
                'email' => 'avery@example.com',
                'message' => 'I would like to plan a charter.',
                'service' => 'charter',
                'yacht' => 'Aurelia',
                'destination' => 'Mediterranean',
                'charter_start_date' => '2027-07-10',
                'charter_end_date' => '2027-07-17',
                'guests' => 8,
                'budget' => 'Up to $150,000',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('sent');

        $this->assertDatabaseHas('contact_enquiries', [
            'name' => 'Avery Morgan',
            'email' => 'avery@example.com',
            'message' => 'I would like to plan a charter.',
            'service' => 'charter',
            'yacht' => 'Aurelia',
            'destination' => 'Mediterranean',
            'charter_start_date' => '2027-07-10 00:00:00',
            'charter_end_date' => '2027-07-17 00:00:00',
            'guests' => 8,
            'budget' => 'Up to $150,000',
        ]);
    }

    public function test_a_signed_in_contact_enquiry_is_linked_to_its_account(): void
    {
        $this->seed(YachtSeeder::class);
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)
            ->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => $user->name,
                'email' => $user->email,
                'message' => 'I would like to discuss a yacht purchase.',
                'service' => 'buy',
                'user_id' => $otherUser->id,
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('sent');

        $this->assertDatabaseHas('contact_enquiries', [
            'user_id' => $user->id,
            'service' => 'buy',
            'message' => 'I would like to discuss a yacht purchase.',
        ]);
    }

    public function test_a_contact_enquiry_rejects_an_unknown_service(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => 'Avery Morgan',
                'email' => 'avery@example.com',
                'message' => 'I would like to discuss a yacht.',
                'service' => 'not-a-service',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors('service');

        $this->assertDatabaseCount('contact_enquiries', 0);
    }

    public function test_a_charter_enquiry_rejects_an_end_date_before_its_start_date(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.send'), [
                'name' => 'Avery Morgan',
                'email' => 'avery@example.com',
                'message' => 'I would like to plan a charter.',
                'charter_start_date' => '2027-07-17',
                'charter_end_date' => '2027-07-10',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors('charter_end_date');

        $this->assertDatabaseCount('contact_enquiries', 0);
    }
}
