<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Newton Mutharimi',
                'job_title' => 'Founder, Nemu Collections',
                'profile_picture' => 'uploads/testimonials/newton-mutharimi-profile.png',
                'cover_image' => 'uploads/testimonials/covers/newton-mutharimi.png',
                'youtube_link' => null,
                'testimony' => 'DD Models Agency gave me more than a platform—it gave me the foundation to grow. I joined as an aspiring model, and through the mentorship, opportunities, and confidence I gained, I discovered my passion for fashion. Today, I proudly run my own fashion house, Nemu Collections. I will always be grateful to DD Models for nurturing my talent and helping shape the creative entrepreneur I have become.',
                'ratings' => 5,
                'media_type' => 'cover',
            ],
            [
                'name' => 'Sarah',
                'job_title' => 'Model',
                'profile_picture' => 'uploads/testimonials/sarah-profile.png',
                'cover_image' => 'uploads/testimonials/covers/sarah.png',
                'youtube_link' => null,
                'testimony' => "I'm truly grateful to DD Models for being part of the beginning of my modeling journey. They provided me with valuable training that helped build my confidence and professionalism, and they also gave me opportunities to work on jobs that introduced me to amazing people and valuable industry experience. I'm thankful for the foundation they gave me and would recommend them to anyone looking to start a career in modeling.",
                'ratings' => 5,
                'media_type' => 'cover',
            ],
            [
                'name' => 'Lyn Mulati',
                'job_title' => 'Model Coach / Trainer',
                'profile_picture' => 'uploads/testimonials/lyn-mulati-profile.png',
                'cover_image' => 'uploads/testimonials/covers/lyn-mulati.png',
                'youtube_link' => null,
                'testimony' => 'Working with DD Models Agency as a coach has shown me what real talent development looks like. I have watched shy newcomers grow into confident professionals ready for the runway and the camera. We invest in poise, presentation, and the discipline this industry demands. It is a privilege to help models find their stride, and I am proud to be part of a team that develops talent holistically—not just for one booking, but for lasting careers.',
                'ratings' => 5,
                'media_type' => 'cover',
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        foreach (range(1, 5) as $page) {
            Cache::forget("models_page_{$page}");
        }

        Cache::forget('models_testimonials');
        Cache::forget('homepage_testimonials');
    }
}
