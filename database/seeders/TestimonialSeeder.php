<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $profileDir = storage_path('app/public/uploads/testimonials');
        $coverDir = storage_path('app/public/uploads/testimonials/covers');
        File::ensureDirectoryExists($profileDir);
        File::ensureDirectoryExists($coverDir);

        $testimonials = [
            [
                'name' => 'Newton Mutharimi',
                'job_title' => 'Founder, Nemu Collections',
                'profile_source' => 'public/team-newton-mutharimi.png',
                'profile_name' => 'newton-mutharimi-profile.png',
                'cover_source' => 'public/team-newton-mutharimi.png',
                'cover_name' => 'newton-mutharimi.png',
                'youtube_link' => null,
                'testimony' => 'DD Models Agency gave me more than a platform—it gave me the foundation to grow. I joined as an aspiring model, and through the mentorship, opportunities, and confidence I gained, I discovered my passion for fashion. Today, I proudly run my own fashion house, Nemu Collections. I will always be grateful to DD Models for nurturing my talent and helping shape the creative entrepreneur I have become.',
                'ratings' => 5,
                'media_type' => 'cover',
            ],
            [
                'name' => 'Sarah',
                'job_title' => 'Model',
                'profile_source' => 'public/assets/img/person/person-f-5.webp',
                'profile_name' => 'sarah-profile.webp',
                'cover_source' => 'public/hero-find-model-1-editorial-duo.png',
                'cover_name' => 'sarah.png',
                'youtube_link' => null,
                'testimony' => "I'm truly grateful to DD Models for being part of the beginning of my modeling journey. They provided me with valuable training that helped build my confidence and professionalism, and they also gave me opportunities to work on jobs that introduced me to amazing people and valuable industry experience. I'm thankful for the foundation they gave me and would recommend them to anyone looking to start a career in modeling.",
                'ratings' => 5,
                'media_type' => 'cover',
            ],
            [
                'name' => 'Lyn Mulati',
                'job_title' => 'Model Coach / Trainer',
                'profile_source' => 'public/team-lyn-mulati.png',
                'profile_name' => 'lyn-mulati-profile.png',
                'cover_source' => 'public/team-lyn-mulati.png',
                'cover_name' => 'lyn-mulati.png',
                'youtube_link' => null,
                'testimony' => 'Working with DD Models Agency as a coach has shown me what real talent development looks like. I have watched shy newcomers grow into confident professionals ready for the runway and the camera. We invest in poise, presentation, and the discipline this industry demands. It is a privilege to help models find their stride, and I am proud to be part of a team that develops talent holistically—not just for one booking, but for lasting careers.',
                'ratings' => 5,
                'media_type' => 'cover',
            ],
        ];

        foreach ($testimonials as $data) {
            $profilePath = $this->copyImage(
                $data['profile_source'],
                $profileDir . DIRECTORY_SEPARATOR . $data['profile_name']
            );
            $coverPath = $this->copyImage(
                $data['cover_source'],
                $coverDir . DIRECTORY_SEPARATOR . $data['cover_name']
            );

            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                [
                    'job_title' => $data['job_title'],
                    'profile_picture' => $profilePath,
                    'cover_image' => $coverPath,
                    'youtube_link' => $data['youtube_link'],
                    'testimony' => $data['testimony'],
                    'ratings' => $data['ratings'],
                    'media_type' => $data['media_type'],
                ]
            );
        }

        foreach (range(1, 5) as $page) {
            Cache::forget("models_page_{$page}");
        }

        Cache::forget('models_testimonials');
        Cache::forget('homepage_testimonials');
    }

    private function copyImage(string $sourceRelative, string $destination): ?string
    {
        $source = base_path($sourceRelative);

        if (! File::exists($source)) {
            return null;
        }

        File::copy($source, $destination);

        return str_replace(storage_path('app/public') . DIRECTORY_SEPARATOR, '', $destination);
    }
}
