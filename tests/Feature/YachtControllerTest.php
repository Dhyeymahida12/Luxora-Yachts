<?php

namespace Tests\Feature;

use App\Models\Yacht;
use Database\Seeders\YachtSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YachtControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_yacht_directory_filters_records_from_the_database(): void
    {
        $this->seed(YachtSeeder::class);

        $this->get(route('yachts.index', [
            'type' => 'sailing',
            'guests' => 8,
            'budget' => 75000,
        ]))
            ->assertOk()
            ->assertSee('yacht-directory__filters', false)
            ->assertSee('VIEW FULL PROFILE')
            ->assertSee('Solstice')
            ->assertSee('Calypso')
            ->assertDontSee('Aurelia');
    }

    public function test_a_yacht_profile_shows_its_stored_specifications_and_amenities(): void
    {
        $this->seed(YachtSeeder::class);

        $this->get(route('yachts.show', 'aurelia'))
            ->assertOk()
            ->assertSee('34 m')
            ->assertSee('8 guests')
            ->assertSee('1,800 nautical miles')
            ->assertSee('Open-air dining')
            ->assertSee('illustrative examples');
    }

    public function test_directory_paginates_twelve_profiles_and_every_profile_has_a_distinct_image(): void
    {
        $this->seed(YachtSeeder::class);

        $response = $this->get(route('yachts.index'));
        $response->assertOk();

        $images = Yacht::query()->orderBy('id')->pluck('image')->all();
        $this->assertCount(12, $images);

        $imageHashes = [];

        foreach ($images as $image) {
            $imagePath = public_path('images/'.$image);
            $this->assertFileExists($imagePath);
            $imageHashes[] = hash_file('sha256', $imagePath);
        }

        $this->assertSame(count($images), count(array_unique($imageHashes)));

        $response
            ->assertSee('12 yacht profiles')
            ->assertSee('page=2', false)
            ->assertSee('Elysian')
            ->assertDontSee('Solstice');

        $this->get(route('yachts.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Solstice')
            ->assertDontSee('Aurelia');
    }

    public function test_unpublished_yachts_are_not_visible_in_the_directory_or_profile(): void
    {
        $this->seed(YachtSeeder::class);
        Yacht::query()->where('slug', 'aurelia')->update(['is_published' => false]);

        $this->get(route('yachts.index'))
            ->assertOk()
            ->assertDontSee('Aurelia');

        $this->get(route('yachts.show', 'aurelia'))->assertNotFound();
    }

    public function test_yacht_search_treats_search_text_as_data_not_sql(): void
    {
        $this->seed(YachtSeeder::class);

        $this->get(route('yachts.index', ['q' => "%' OR 1=1 --"]))
            ->assertOk()
            ->assertSee('0 yacht profiles')
            ->assertDontSee('Aurelia');
    }
}
