<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogsCategory;
use App\Models\User;
use App\Support\SeedImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();

        if (! $author) {
            $this->command?->warn('No users found. Skipping blog seed.');

            return;
        }

        $storageDir = storage_path('app/public/blogs');
        File::ensureDirectoryExists($storageDir);

        $category = BlogsCategory::updateOrCreate(
            ['name' => 'modelling'],
            ['blogs_category_title' => 'Modelling']
        );

        $posts = [
            [
                'title' => 'Why Dare to Dream Is the Right Agency for Aspiring Models in Kenya',
                'slug' => 'why-dare-to-dream-is-the-right-agency-for-aspiring-models',
                'excerpt' => 'Discover how DD Models Agency supports new talent with mentorship, training, and real industry opportunities across Kenya.',
                'image_source' => 'public/hero-find-model-3-trio-steps.png',
                'image_name' => 'dare-to-dream-agency-aspiring-models.webp',
                'model' => 'DD Models Talent',
                'photographer' => 'DD Models Creative Team',
                'brand' => 'Dare to Dream Modelling Agency',
                'content' => <<<'HTML'
<p>Breaking into modelling can feel overwhelming, especially when you are not sure where to start. At <strong>Dare to Dream Modelling Agency (DD Models)</strong>, we believe every aspiring model deserves guidance, structure, and a clear path forward.</p>

<p>Our agency was built to do more than book faces for campaigns. We focus on <strong>talent development, mentorship, professionalism, and long-term growth</strong>. From your first audition to your first paid job, our team works with you to build confidence, polish your portfolio, and understand how the industry really works.</p>

<p>What makes DD Models different is our hands-on approach. Models train with experienced coaches, receive feedback on runway and camera presence, and get connected to opportunities with brands, events, and productions that match their potential.</p>

<p>Whether you are a newcomer exploring modelling for the first time or a rising talent ready for bigger stages, Dare to Dream gives you a supportive environment to grow. We are locally rooted in Kenya with global ambitions — and we are always looking for fresh faces who are ready to learn, work hard, and shine.</p>

<p><strong>Dare To Dream. Develop. Shine. Succeed.</strong> If modelling is your dream, DD Models Agency is where that dream becomes a plan.</p>
HTML,
            ],
            [
                'title' => '5 Things Every New Model Should Know Before Their First Shoot',
                'slug' => 'five-things-every-new-model-should-know-first-shoot',
                'excerpt' => 'Practical modelling advice from the DD Models team to help you show up prepared, confident, and professional on set.',
                'image_source' => 'public/hero-find-model-1-editorial-duo.png',
                'image_name' => 'new-model-first-shoot-tips.webp',
                'model' => 'DD Models Roster',
                'photographer' => 'DD Models Studio',
                'brand' => 'Dare to Dream Modelling Agency',
                'content' => <<<'HTML'
<p>Your first professional shoot is an exciting milestone — and preparation makes all the difference. At <strong>Dare to Dream Modelling Agency</strong>, we coach our models to treat every booking like a career-building moment, not just a photo session.</p>

<p><strong>1. Arrive prepared.</strong> Know your call time, location, and wardrobe requirements. Being early and organised shows clients you are reliable.</p>

<p><strong>2. Take care of your skin and body.</strong> Rest well, stay hydrated, and keep grooming simple before a shoot. A fresh, healthy look always photographs better.</p>

<p><strong>3. Practice your poses and expressions.</strong> Confidence in front of the camera comes from repetition. Our coaches at DD Models help talent develop a natural, versatile look book of poses.</p>

<p><strong>4. Communicate professionally.</strong> Listen to direction, ask questions when needed, and stay respectful on set. Agencies and clients remember models who are easy to work with.</p>

<p><strong>5. Think long term.</strong> One shoot is not the finish line — it is a step in your journey. Build relationships, update your portfolio, and keep training.</p>

<p>DD Models Agency exists to help you grow through every stage of that journey. With the right mindset and support, your first shoot can become the start of a lasting modelling career.</p>
HTML,
            ],
        ];

        foreach ($posts as $post) {
            $imagePath = null;
            $source = base_path($post['image_source']);

            if (File::exists($source)) {
                $destination = $storageDir . DIRECTORY_SEPARATOR . $post['image_name'];
                $storedPath = SeedImage::storeOptimized($source, $destination);
                $imagePath = $storedPath ? '/storage/' . $storedPath : null;
            }

            $wordCount = str_word_count(strip_tags($post['content']));

            Blog::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'image' => $imagePath,
                    'blogs_category_id' => $category->id,
                    'user_id' => $author->id,
                    'read_time' => max(1, (int) ceil($wordCount / 200)),
                    'published_at' => now()->subDays($post['slug'] === $posts[0]['slug'] ? 3 : 1),
                    'model' => $post['model'],
                    'photographer' => $post['photographer'],
                    'brand' => $post['brand'],
                ]
            );
        }

        Cache::forget('blog_categories');
        Cache::flush();
    }
}
