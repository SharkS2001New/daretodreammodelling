<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\User;
use App\Models\UserPublicInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        $storageDir = storage_path('app/public/uploads/models');
        File::ensureDirectoryExists($storageDir);

        $models = [
            [
                'name' => 'Amina Wanjiru',
                'email' => 'amina.wanjiru@ddmodels.local',
                'display_name' => 'Amina W',
                'gender' => 'Female',
                'age' => 22,
                'location' => 'Nairobi, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Black',
                'eye' => 'Brown',
                'height' => '5\'9"',
                'shoes' => '39EU / 6US / 6UK',
                'about_me' => 'Runway and commercial model with a passion for fashion editorials.',
                'photos' => [
                    'public/assets/img/portfolio/portfolio-portrait-1.webp',
                    'public/hero-find-model-1-editorial-duo.png',
                ],
            ],
            [
                'name' => 'Zara Okello',
                'email' => 'zara.okello@ddmodels.local',
                'display_name' => 'Zara O',
                'gender' => 'Female',
                'age' => 24,
                'location' => 'Nairobi, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Black',
                'eye' => 'Brown',
                'height' => '5\'8"',
                'shoes' => '38EU / 5US / 5UK',
                'about_me' => 'Editorial and beauty model available for campaigns and brand activations.',
                'photos' => [
                    'public/assets/img/portfolio/portfolio-portrait-2.webp',
                    'public/hero-find-model-4-street-style.png',
                ],
            ],
            [
                'name' => 'Brian Ochieng',
                'email' => 'brian.ochieng@ddmodels.local',
                'display_name' => 'Brian O',
                'gender' => 'Male',
                'age' => 26,
                'location' => 'Nairobi, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Black',
                'eye' => 'Brown',
                'height' => '6\'1"',
                'shoes' => '43EU / 10US / 9UK',
                'about_me' => 'Commercial and fashion model with experience in brand campaigns.',
                'photos' => [
                    'public/hero-find-model-2-male-fashion.png',
                    'public/find_a_model.jpg',
                ],
            ],
            [
                'name' => 'Grace Mwangi',
                'email' => 'grace.mwangi@ddmodels.local',
                'display_name' => 'Grace M',
                'gender' => 'Female',
                'age' => 21,
                'location' => 'Mombasa, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Brown',
                'eye' => 'Brown',
                'height' => '5\'7"',
                'shoes' => '38EU / 5US / 5UK',
                'about_me' => 'Emerging talent focused on pageantry and commercial modelling.',
                'photos' => [
                    'public/assets/img/portfolio/portfolio-portrait-4.webp',
                    'public/hero-find-model-3-trio-steps.png',
                ],
            ],
            [
                'name' => 'Daniel Kamau',
                'email' => 'daniel.kamau@ddmodels.local',
                'display_name' => 'Daniel K',
                'gender' => 'Male',
                'age' => 23,
                'location' => 'Nairobi, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Black',
                'eye' => 'Brown',
                'height' => '6\'0"',
                'shoes' => '42EU / 9US / 8UK',
                'about_me' => 'Versatile model for runway, lookbooks, and lifestyle shoots.',
                'photos' => [
                    'public/assets/img/person/person-m-8.webp',
                    'public/model_careers1.jpg',
                ],
            ],
            [
                'name' => 'Kevin Mutua',
                'email' => 'kevin.mutua@ddmodels.local',
                'display_name' => 'Kevin M',
                'gender' => 'Male',
                'age' => 25,
                'location' => 'Nairobi, Kenya',
                'nationality' => 'Kenya',
                'ethnicity' => 'Black/African',
                'hair' => 'Black',
                'eye' => 'Brown',
                'height' => '6\'2"',
                'shoes' => '44EU / 11US / 10UK',
                'about_me' => 'Fitness and commercial model with a confident on-camera presence.',
                'photos' => [
                    'public/assets/img/person/person-m-12.webp',
                    'public/become-model-haunter.jpg',
                ],
            ],
        ];

        foreach ($models as $modelData) {
            $user = User::updateOrCreate(
                ['email' => $modelData['email']],
                [
                    'name' => $modelData['name'],
                    'slug' => Str::slug($modelData['name']),
                    'password' => Hash::make(Str::random(32)),
                    'email_verified_at' => now(),
                ]
            );

            $profilePicture = null;
            $photoPaths = [];

            foreach ($modelData['photos'] as $index => $sourceRelative) {
                $source = base_path($sourceRelative);
                if (! File::exists($source)) {
                    continue;
                }

                $extension = pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg';
                $filename = Str::slug($modelData['name']) . '-' . ($index + 1) . '.' . $extension;
                $destination = $storageDir . DIRECTORY_SEPARATOR . $filename;
                File::copy($source, $destination);

                $relativePath = 'uploads/models/' . $filename;
                $photoPaths[] = $relativePath;

                if ($index === 0) {
                    $profilePicture = $relativePath;
                }
            }

            if (empty($photoPaths)) {
                continue;
            }

            UserPublicInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'display_name' => $modelData['display_name'],
                    'age' => $modelData['age'],
                    'gender' => $modelData['gender'],
                    'location' => $modelData['location'],
                    'nationality' => $modelData['nationality'],
                    'ethnicity' => $modelData['ethnicity'],
                    'hair' => $modelData['hair'],
                    'eye' => $modelData['eye'],
                    'height' => $modelData['height'],
                    'shoes' => $modelData['shoes'],
                    'languages' => 'English, Swahili',
                    'about_me' => $modelData['about_me'],
                    'profile_picture' => $profilePicture,
                ]
            );

            foreach ($photoPaths as $photoPath) {
                Photo::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'file_path' => $photoPath,
                    ]
                );
            }
        }
    }
}
