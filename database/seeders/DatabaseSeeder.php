<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'is_admin' => true,
                'password' => bcrypt('password'),
            ]
        );

        $users = User::factory(5)->create();

        if (\App\Models\Category::count() === 0) {
            $categories = collect([
            ['name' => 'Beach', 'slug' => 'beach'],
            ['name' => 'Mountains', 'slug' => 'mountains'],
            ['name' => 'Food', 'slug' => 'food'],
            ['name' => 'City', 'slug' => 'city'],
            ['name' => 'Nature', 'slug' => 'nature'],
        ])->map(fn ($cat) => \App\Models\Category::create($cat));

        $locations = collect([
            ['name' => 'Maldives', 'slug' => 'maldives'],
            ['name' => 'Swiss Alps', 'slug' => 'swiss-alps'],
            ['name' => 'Tokyo, Japan', 'slug' => 'tokyo-japan'],
            ['name' => 'Santorini, Greece', 'slug' => 'santorini-greece'],
            ['name' => 'Bali, Indonesia', 'slug' => 'bali-indonesia'],
            ['name' => 'New York', 'slug' => 'new-york'],
            ['name' => 'Paris, France', 'slug' => 'paris-france'],
            ['name' => 'Iceland', 'slug' => 'iceland'],
        ])->map(fn ($loc) => \App\Models\Location::create($loc));

        $destinations = [
            [
                'user_id' => $users[0]->id,
                'destination' => 'Crystal Clear Waters at Maldives',
                'location' => 'Maldives',
                'activities' => 'snorkeling, diving, swimming',
                'caption' => 'The waters are so clear you can see the tropical fish right from the surface. Perfect spot for beginners and advanced divers alike. Highly recommend visiting in November to March for the best weather.',
                'category_id' => $categories[0]->id, // Beach
                'managed_location_id' => $locations[0]->id,
                'media' => ['https://images.unsplash.com/photo-1559827260-dc66d52bef19?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 245,
                'likes_count' => 98,
                'share_count' => 32,
            ],
            [
                'user_id' => $users[1]->id,
                'destination' => 'Hiking the Eiger North Face trail',
                'location' => 'Swiss Alps',
                'activities' => 'hiking, mountaineering, photography',
                'caption' => 'One of the most challenging and rewarding hikes in the Alps. The views are absolutely stunning. Make sure you bring proper gear and start early in the morning.',
                'category_id' => $categories[1]->id, // Mountains
                'managed_location_id' => $locations[1]->id,
                'media' => ['https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 512,
                'likes_count' => 187,
                'share_count' => 64,
            ],
            [
                'user_id' => $users[2]->id,
                'destination' => 'Street Food Heaven in Shibuya',
                'location' => 'Tokyo, Japan',
                'activities' => 'food tour, street eats, cultural experience',
                'caption' => 'Takoyaki, okonomiyaki, ramen—Tokyo has it all. The Shibuya food scene is incredible and super affordable. Pro tip: go late at night after 9 PM for the best crowds.',
                'category_id' => $categories[2]->id, // Food
                'managed_location_id' => $locations[2]->id,
                'media' => ['https://images.unsplash.com/photo-1524353570885-a898bedb0b5f?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1524353570885-a898bedb0b5f?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 678,
                'likes_count' => 234,
                'share_count' => 102,
            ],
            [
                'user_id' => $users[3]->id,
                'destination' => 'Sunset at Oia Village',
                'location' => 'Santorini, Greece',
                'activities' => 'sunset viewing, wine tasting, island hopping',
                'caption' => 'The most iconic sunset in the world. Skip the main viewpoint—go to a quiet spot on the cliff for a more peaceful experience. The wine here is fantastic too!',
                'category_id' => $categories[0]->id, // Beach
                'managed_location_id' => $locations[3]->id,
                'media' => ['https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 1203,
                'likes_count' => 456,
                'share_count' => 178,
            ],
            [
                'user_id' => $users[4]->id,
                'destination' => 'Ubud Rice Terraces Adventure',
                'location' => 'Bali, Indonesia',
                'activities' => 'rice field tours, yoga, meditation, shopping',
                'caption' => 'Walking through the Ubud rice terraces is like being in another world. The locals are so friendly, and the prices are incredibly cheap. Don\'t miss the monkey forest nearby!',
                'category_id' => $categories[4]->id, // Nature
                'managed_location_id' => $locations[4]->id,
                'media' => ['https://images.unsplash.com/photo-1537225228614-b504c3b52cf7?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1537225228614-b504c3b52cf7?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 889,
                'likes_count' => 342,
                'share_count' => 125,
            ],
            [
                'user_id' => $users[0]->id,
                'destination' => 'Times Square Energy Rush',
                'location' => 'New York',
                'activities' => 'sightseeing, shopping, Broadway shows',
                'caption' => 'It\'s chaotic, it\'s loud, but there\'s nothing quite like Times Square at night. Try going on a quiet weekday morning instead of weekends.',
                'category_id' => $categories[3]->id, // City
                'managed_location_id' => $locations[5]->id,
                'media' => ['https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 445,
                'likes_count' => 172,
                'share_count' => 58,
            ],
            [
                'user_id' => $users[1]->id,
                'destination' => 'Eiffel Tower Romance',
                'location' => 'Paris, France',
                'activities' => 'sightseeing, dining, museum tours',
                'caption' => 'The City of Light lives up to the hype. Book a table at a small bistro near the tower for dinner, then take a stroll along the Seine. Magical!',
                'category_id' => $categories[3]->id, // City
                'managed_location_id' => $locations[6]->id,
                'media' => ['https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 756,
                'likes_count' => 298,
                'share_count' => 89,
            ],
            [
                'user_id' => $users[2]->id,
                'destination' => 'Blue Lagoon Geothermal Spa',
                'location' => 'Iceland',
                'activities' => 'spa, geothermal pools, northern lights viewing',
                'caption' => 'Soaking in the warm geothermal waters while surrounded by snow and ice is surreal. The silica mud is great for your skin too. Visit in winter for a chance to see the Northern Lights!',
                'category_id' => $categories[4]->id, // Nature
                'managed_location_id' => $locations[7]->id,
                'media' => ['https://images.unsplash.com/photo-1511884642898-4c92249e20b6?auto=format&fit=crop&w=1200&q=80'],
                'image_path' => 'https://images.unsplash.com/photo-1511884642898-4c92249e20b6?auto=format&fit=crop&w=1200&q=80',
                'views_count' => 934,
                'likes_count' => 378,
                'share_count' => 142,
            ],
        ];

        foreach ($destinations as $dest) {
            \App\Models\Post::create($dest);
        }

        \App\Models\Setting::setValue('website_name', 'Finder');
        \App\Models\Setting::setValue('theme_color', 'rose');
        \App\Models\Setting::setValue('approval_required', 'false');
        \App\Models\Setting::setValue('maintenance_mode', 'false');
        }
}
