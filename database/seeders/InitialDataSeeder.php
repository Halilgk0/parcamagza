<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Part;
use Illuminate\Support\Facades\File;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create necessary directories
        $this->createImageDirectories();

        // Create placeholder images for brands
        $this->createPlaceholderImages();

        // Create hero image for homepage
        $this->createHeroImage();

        // Create Brands
        $bmw = CarBrand::create([
            'name' => 'BMW',
            'description' => 'Bavyera Motor Fabrikası',
            'logo' => 'images/brands/bmw-logo.svg',
            'is_active' => true
        ]);

        $mercedes = CarBrand::create([
            'name' => 'Mercedes-Benz',
            'description' => 'Premium Alman otomobil üreticisi',
            'logo' => 'images/brands/mercedes-logo.svg',
            'is_active' => true
        ]);

        $audi = CarBrand::create([
            'name' => 'Audi',
            'description' => 'Vorsprung durch Technik',
            'logo' => 'images/brands/audi-logo.svg',
            'is_active' => true
        ]);

        $volkswagen = CarBrand::create([
            'name' => 'Volkswagen',
            'description' => 'Das Auto',
            'logo' => 'images/brands/vw-logo.svg',
            'is_active' => true
        ]);

        // Create Models
        $bmw3 = CarModel::create([
            'car_brand_id' => $bmw->id,
            'name' => '3 Serisi',
            'year_start' => '1975',
            'year_end' => null,
            'description' => 'BMW\'nin lüks kompakt sedan modeli',
            'is_active' => true
        ]);

        $c_class = CarModel::create([
            'car_brand_id' => $mercedes->id,
            'name' => 'C-Serisi',
            'year_start' => '1993',
            'year_end' => null,
            'description' => 'Mercedes-Benz\'in orta sınıf lüks sedan modeli',
            'is_active' => true
        ]);

        $a4 = CarModel::create([
            'car_brand_id' => $audi->id,
            'name' => 'A4',
            'year_start' => '1994',
            'year_end' => null,
            'description' => 'Audi\'nin orta sınıf lüks sedan modeli',
            'is_active' => true
        ]);

        $golf = CarModel::create([
            'car_brand_id' => $volkswagen->id,
            'name' => 'Golf',
            'year_start' => '1974',
            'year_end' => null,
            'description' => 'Volkswagen\'in efsanevi hatchback modeli',
            'is_active' => true
        ]);

        // Create Categories with Images
        $engine = Category::create([
            'name' => 'Motor Parçaları',
            'description' => 'Motor ve ilgili parçalar',
            'icon' => 'fa-engine',
            'image' => 'images/categories/engine.svg',
            'is_active' => true
        ]);

        $brake = Category::create([
            'name' => 'Fren Sistemi',
            'description' => 'Fren sistemi parçaları',
            'icon' => 'fa-brake',
            'image' => 'images/categories/brake.svg',
            'is_active' => true
        ]);

        // Create Sub-categories with Images
        $pistons = Category::create([
            'name' => 'Pistonlar',
            'description' => 'Motor pistonları',
            'icon' => 'fa-circle',
            'image' => 'images/categories/piston.svg',
            'parent_id' => $engine->id,
            'is_active' => true
        ]);

        $pads = Category::create([
            'name' => 'Fren Balataları',
            'description' => 'Fren balataları ve padleri',
            'icon' => 'fa-square',
            'image' => 'images/categories/brake-pad.svg',
            'parent_id' => $brake->id,
            'is_active' => true
        ]);

        // Create category images
        $this->createCategoryImages();

        // Create Parts with Images
        $part1 = Part::create([
            'category_id' => $pistons->id,
            'name' => 'BMW N52 Motor Pistonu',
            'part_number' => 'BMW-N52-PST',
            'description' => 'BMW N52 motoru için orijinal piston',
            'price' => 1250.00,
            'stock_quantity' => 15,
            'condition' => 'new',
            'manufacturer' => 'BMW',
            'image' => 'images/parts/bmw-piston.svg',
            'specifications' => [
                'Çap' => '84mm',
                'Malzeme' => 'Alüminyum alaşım',
                'Ağırlık' => '400g'
            ],
            'is_active' => true
        ]);

        $part2 = Part::create([
            'category_id' => $pads->id,
            'name' => 'Mercedes-Benz C-Serisi Ön Fren Balatası',
            'part_number' => 'MB-C-BRK-001',
            'description' => 'Mercedes-Benz C-Serisi için orijinal ön fren balatası seti',
            'price' => 850.00,
            'stock_quantity' => 25,
            'condition' => 'new',
            'manufacturer' => 'Mercedes-Benz',
            'image' => 'images/parts/mercedes-brake.svg',
            'specifications' => [
                'Pozisyon' => 'Ön',
                'Malzeme' => 'Seramik',
                'Garanti' => '2 yıl'
            ],
            'is_active' => true
        ]);

        $part3 = Part::create([
            'category_id' => $pistons->id,
            'name' => 'Audi 2.0 TFSI Motor Pistonu',
            'part_number' => 'AUDI-2.0TFSI-PST',
            'description' => 'Audi 2.0 TFSI motoru için orijinal piston',
            'price' => 1150.00,
            'stock_quantity' => 10,
            'condition' => 'new',
            'manufacturer' => 'Audi',
            'image' => 'images/parts/audi-piston.svg',
            'specifications' => [
                'Çap' => '82.5mm',
                'Malzeme' => 'Alüminyum alaşım',
                'Ağırlık' => '380g'
            ],
            'is_active' => true
        ]);

        $part4 = Part::create([
            'category_id' => $pads->id,
            'name' => 'Volkswagen Golf Arka Fren Balatası',
            'part_number' => 'VW-GOLF-BRK-002',
            'description' => 'Volkswagen Golf için orijinal arka fren balatası seti',
            'price' => 650.00,
            'stock_quantity' => 30,
            'condition' => 'new',
            'manufacturer' => 'Volkswagen',
            'image' => 'images/parts/vw-brake.svg',
            'specifications' => [
                'Pozisyon' => 'Arka',
                'Malzeme' => 'Seramik',
                'Garanti' => '2 yıl'
            ],
            'is_active' => true
        ]);

        // Create part images
        $this->createPartImages();

        // Add compatibility
        $part1->compatibleModels()->attach($bmw3->id);
        $part2->compatibleModels()->attach($c_class->id);
        $part3->compatibleModels()->attach($a4->id);
        $part4->compatibleModels()->attach($golf->id);
    }

    private function createImageDirectories()
    {
        $directories = [
            'images/brands',
            'images/categories',
            'images/parts',
            'images/hero'
        ];

        foreach ($directories as $dir) {
            $path = public_path($dir);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }
        }
    }

    private function createPlaceholderImages()
    {
        $brands = [
            'bmw' => ['#0066B1', 'BMW'],
            'mercedes' => ['#000000', 'MERCEDES'],
            'audi' => ['#BB0A30', 'AUDI'],
            'vw' => ['#001E50', 'VW']
        ];

        foreach ($brands as $brand => $info) {
            list($color, $text) = $info;
            $svg = <<<SVG
            <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="white"/>
                <circle cx="100" cy="100" r="75" fill="{$color}"/>
                <text x="100" y="100" font-family="Arial" font-size="24" fill="white" text-anchor="middle" dominant-baseline="middle">{$text}</text>
            </svg>
            SVG;
            
            File::put(public_path("images/brands/{$brand}-logo.svg"), $svg);
        }

        // Update brand logo paths in database
        CarBrand::where('name', 'BMW')->update(['logo' => 'images/brands/bmw-logo.svg']);
        CarBrand::where('name', 'Mercedes-Benz')->update(['logo' => 'images/brands/mercedes-logo.svg']);
        CarBrand::where('name', 'Audi')->update(['logo' => 'images/brands/audi-logo.svg']);
        CarBrand::where('name', 'Volkswagen')->update(['logo' => 'images/brands/vw-logo.svg']);
    }

    private function createCategoryImages()
    {
        $categories = [
            'engine' => ['#4A90E2', 'ENGINE'],
            'brake' => ['#F5A623', 'BRAKE'],
            'piston' => ['#7ED321', 'PISTON'],
            'brake-pad' => ['#BD10E0', 'BRAKE PAD']
        ];

        foreach ($categories as $category => $info) {
            list($color, $text) = $info;
            $svg = <<<SVG
            <svg width="300" height="200" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="{$color}" opacity="0.1"/>
                <rect x="10" y="10" width="280" height="180" rx="10" fill="{$color}" opacity="0.2"/>
                <text x="150" y="100" font-family="Arial" font-size="24" fill="{$color}" text-anchor="middle" dominant-baseline="middle">{$text}</text>
            </svg>
            SVG;
            
            File::put(public_path("images/categories/{$category}.svg"), $svg);
        }
    }

    private function createPartImages()
    {
        $parts = [
            'bmw-piston' => ['#0066B1', 'BMW PISTON'],
            'mercedes-brake' => ['#000000', 'MERCEDES BRAKE'],
            'audi-piston' => ['#BB0A30', 'AUDI PISTON'],
            'vw-brake' => ['#001E50', 'VW BRAKE']
        ];

        foreach ($parts as $part => $info) {
            list($color, $text) = $info;
            $svg = <<<SVG
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="white"/>
                <rect x="20" y="20" width="360" height="260" rx="15" fill="{$color}" opacity="0.1"/>
                <text x="200" y="150" font-family="Arial" font-size="24" fill="{$color}" text-anchor="middle" dominant-baseline="middle">{$text}</text>
            </svg>
            SVG;
            
            File::put(public_path("images/parts/{$part}.svg"), $svg);
        }
    }

    private function createHeroImage()
    {
        $svg = <<<SVG
        <svg width="1200" height="600" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#0066B1;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#BB0A30;stop-opacity:1" />
                </linearGradient>
            </defs>
            <rect width="100%" height="100%" fill="url(#grad)" opacity="0.9"/>
            <text x="600" y="250" font-family="Arial" font-size="48" fill="white" text-anchor="middle">ARAÇ PARÇALARI</text>
            <text x="600" y="350" font-family="Arial" font-size="24" fill="white" text-anchor="middle">Kaliteli ve Uygun Fiyatlı</text>
        </svg>
        SVG;
        
        File::put(public_path("images/hero/hero-car.svg"), $svg);
    }
}
