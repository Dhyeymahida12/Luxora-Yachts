<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\NewsletterSubscription;
use App\Models\SiteContent;
use App\Models\User;
use App\Models\Yacht;
use Database\Seeders\YachtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_and_non_admin_users_cannot_access_the_admin_panel(): void
    {
        config(['admin.email' => 'admin@example.com']);

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create(['email' => 'member@example.com']))
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_the_admin_dashboard_reads_summary_counts_from_the_database(): void
    {
        $admin = $this->admin();
        $this->seed(YachtSeeder::class);
        ContactEnquiry::create([
            'name' => 'Casey Client',
            'email' => 'casey@example.com',
            'message' => 'Please send charter details.',
        ]);
        NewsletterSubscription::create(['email' => 'reader@example.com']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('12')
            ->assertSee('Casey Client')
            ->assertDontSee('reader@example.com');
    }

    public function test_admin_can_create_update_publish_and_delete_yacht_profiles(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);

        $this->post(route('admin.yachts.store'), $this->validYachtData())
            ->assertRedirect(route('admin.yachts.edit', 'sample-yacht'));

        $this->assertDatabaseHas('yachts', [
            'slug' => 'sample-yacht',
            'name' => 'Sample Yacht',
            'type' => 'motor',
            'is_illustrative' => true,
            'is_published' => true,
        ]);

        $this->get(route('yachts.show', 'sample-yacht'))
            ->assertOk()
            ->assertSee('Sample Yacht');

        $this->patch(route('admin.yachts.update', 'sample-yacht'), [
            ...$this->validYachtData(),
            'name' => 'Updated Sample Yacht',
            'is_illustrative' => '1',
            'is_published' => '0',
        ])->assertRedirect();

        $this->assertDatabaseHas('yachts', [
            'slug' => 'sample-yacht',
            'name' => 'Updated Sample Yacht',
            'is_published' => 0,
        ]);

        $this->delete(route('admin.yachts.destroy', 'sample-yacht'))
            ->assertRedirect(route('admin.yachts.index'));

        $this->assertDatabaseMissing('yachts', ['slug' => 'sample-yacht']);
    }

    public function test_invalid_yacht_images_are_rejected_without_creating_a_profile(): void
    {
        $this->actingAs($this->admin())
            ->from(route('admin.yachts.create'))
            ->post(route('admin.yachts.store'), [
                ...$this->validYachtData(),
                'image' => '../.env',
            ])
            ->assertRedirect(route('admin.yachts.create'))
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('yachts', ['slug' => 'sample-yacht']);
    }

    public function test_admin_can_upload_a_yacht_image_to_public_storage(): void
    {
        Storage::fake('s3');
        config(['admin.upload_disk' => 's3']);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.yachts.store'), [
                ...$this->validYachtData(),
                'image' => null,
                'image_file' => UploadedFile::fake()->image('profile.jpg', 900, 500)->size(800),
            ])
            ->assertRedirect(route('admin.yachts.edit', 'sample-yacht'));

        $yacht = Yacht::query()->where('slug', 'sample-yacht')->firstOrFail();
        $this->assertStringStartsWith('storage/yachts/', $yacht->image);
        Storage::disk('s3')->assertExists(str_replace('storage/', '', $yacht->image));
        $this->assertSame(
            Storage::disk('s3')->url(str_replace('storage/', '', $yacht->image)),
            $yacht->image_url,
        );
    }

    public function test_admin_can_update_enquiry_status_and_user_text_is_escaped(): void
    {
        $admin = $this->admin();
        $enquiry = ContactEnquiry::create([
            'name' => '<script>alert(1)</script>',
            'email' => 'client@example.com',
            'message' => '<img src=x onerror=alert(1)>',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.enquiries.index'))
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<img src=x onerror=', false);

        $this->patch(route('admin.enquiries.update', $enquiry), ['status' => 'replied'])
            ->assertRedirect();

        $this->assertDatabaseHas('contact_enquiries', [
            'id' => $enquiry->id,
            'status' => 'replied',
        ]);
    }

    public function test_admin_can_edit_public_page_content_and_markup_is_escaped(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.content.update', 'home'), [
                'headline' => "<script>alert('x')</script>\nNew headline",
                'description' => 'A new homepage introduction.',
                'image' => 'hero.jpg',
            ])
            ->assertRedirect(route('admin.content.index'));

        $this->assertSame(
            "<script>alert('x')</script>\nNew headline",
            SiteContent::query()->where('page_key', 'home')->firstOrFail()->content['headline'],
        );

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertSee('A new homepage introduction.')
            ->assertDontSee("<script>alert('x')</script>", false);
    }

    public function test_admin_can_upload_a_page_image_and_unknown_pages_are_not_editable(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)
            ->put(route('admin.content.update', 'charter'), [
                'eyebrow' => 'A NEW EYEBROW',
                'headline' => 'A NEW CHARTER HEADLINE',
                'description' => 'A new charter introduction.',
                'image' => 'charter-hero.jpg',
                'image_file' => UploadedFile::fake()->image('charter.webp', 900, 500)->size(900),
            ])
            ->assertRedirect(route('admin.content.index'));

        $savedImage = SiteContent::query()->where('page_key', 'charter')->firstOrFail()->content['image'];
        $this->assertStringStartsWith('storage/admin-images/', $savedImage);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $savedImage));

        $this->get(route('admin.content.edit', 'not-a-page'))
            ->assertNotFound();

        $this->get(route('charter'))
            ->assertOk()
            ->assertSee('A NEW CHARTER HEADLINE')
            ->assertSee('storage/admin-images/', false);
    }

    public function test_admin_can_view_and_export_newsletter_subscribers(): void
    {
        $this->actingAs($this->admin());
        NewsletterSubscription::create(['email' => 'reader@example.com']);

        $this->get(route('admin.newsletter.index'))
            ->assertOk()
            ->assertSee('reader@example.com');

        $this->get(route('admin.newsletter.export'))
            ->assertDownload('luxora-newsletter-subscribers.csv');
    }

    private function admin(): User
    {
        config(['admin.email' => 'admin@example.com']);

        return User::factory()->create(['email' => 'admin@example.com']);
    }

    private function validYachtData(): array
    {
        return [
            'slug' => 'sample-yacht',
            'name' => 'Sample Yacht',
            'type' => 'motor',
            'image' => 'yacht-1.jpg',
            'length_m' => 34,
            'guest_capacity' => 8,
            'cabins' => 4,
            'crew_size' => 6,
            'build_year' => 2021,
            'max_speed_knots' => 17,
            'cruising_speed_knots' => 12,
            'range_nm' => 1800,
            'weekly_rate_usd' => 85000,
            'description' => 'An illustrative profile for testing administration.',
            'overview' => 'A sample profile used to verify yacht administration.',
            'cruising_regions' => "Mediterranean\nCaribbean & Bahamas",
            'amenities' => "Open-air dining\nSun deck",
            'is_illustrative' => '1',
            'is_published' => '1',
        ];
    }
}
