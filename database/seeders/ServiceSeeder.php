<?php

namespace Database\Seeders;

use App\Models\JobService;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define service categories
        $serviceCategories = [
            'Home Maintenance and Repair Services',
            'Cleaning and Sanitation Services',
            'Skilled Services',
            'Personal Services',
            'Small Business Support Services',
            'Specialty Services',
            'Appliance and Electronics Services',
            'Event Support Services',
            'Outdoor Services',
        ];

        // Create service categories in the database
        foreach ($serviceCategories as $categoryName) {
            ServiceCategory::create(['title' => $categoryName]);
        }

        // Define services and their corresponding categories
        $services = [
            [
                'category' => 'Home Maintenance and Repair Services',
                'services' => [
                    ['title' => 'Electrician', 'description' => 'Fixing electrical issues, installing light fixtures, repairing outlets.'],
                    ['title' => 'Plumber', 'description' => 'Repairing leaks, unclogging drains, fixing toilets, installing faucets.'],
                    ['title' => 'Carpenter', 'description' => 'Minor furniture repairs, assembling shelves, fixing doors or windows.'],
                    ['title' => 'Painter', 'description' => 'Touch-up painting, single-room repainting, furniture repainting.'],
                    ['title' => 'Handyman', 'description' => 'General repairs, installing curtains or blinds, fixing small appliances.'],
                    ['title' => 'Roof Repair Technician', 'description' => 'Fixing minor roof leaks or replacing small sections of damaged shingles.'],
                    ['title' => 'Waterproofing Specialist', 'description' => 'Sealing basements, patios, or roofs to prevent water damage.'],
                    ['title' => 'Gutter Cleaner', 'description' => 'Cleaning and repairing clogged or broken gutters.'],
                    ['title' => 'Flooring Installer', 'description' => 'Small-scale flooring repairs or single-room installations (vinyl, tiles, or laminate).'],
                ]
            ],
            [
                'category' => 'Cleaning and Sanitation Services',
                'services' => [
                    ['title' => 'Cleaner', 'description' => 'Deep cleaning, post-renovation cleaning, spring cleaning.'],
                    ['title' => 'Pest Control Worker', 'description' => 'Treating infestations (ants, roaches, etc.).'],
                    ['title' => 'Gardener/Landscaper', 'description' => 'Lawn mowing, hedge trimming, planting flowers.'],
                    ['title' => 'Carpet Cleaner', 'description' => 'Deep cleaning carpets or rugs in homes or small businesses.'],
                    ['title' => 'Air Duct Cleaner', 'description' => 'Cleaning HVAC or ventilation systems.'],
                    ['title' => 'Disinfection Service', 'description' => 'Sanitizing homes, offices, or restaurants.'],
                ]
            ],
            [
                'category' => 'Skilled Services',
                'services' => [
                    ['title' => 'HVAC Technician', 'description' => 'Servicing or repairing air conditioning units.'],
                    ['title' => 'Appliance Repair Technician', 'description' => 'Fixing washing machines, refrigerators, or ovens.'],
                    ['title' => 'Locksmith', 'description' => 'Replacing locks, key duplication, or unlocking doors.'],
                    ['title' => 'Glazier', 'description' => 'Replacing broken glass panels in windows, doors, or storefronts.'],
                    ['title' => 'Curtain and Blind Installer', 'description' => 'Installing or repairing curtains, blinds, or drapery rods.'],
                    ['title' => 'Ceiling Repair Specialist', 'description' => 'Fixing small cracks, holes, or water-damaged areas.'],
                    ['title' => 'Car Mechanic', 'description' => 'Repairs and maintains car machinery.'],
                ]
            ],
            [
                'category' => 'Personal Services',
                'services' => [
                    ['title' => 'Manicurist/Pedicurist', 'description' => 'Providing nail care services.'],
                    ['title' => 'Hairdresser/Barber', 'description' => 'Haircuts or styling at home.'],
                    ['title' => 'Massage Therapist', 'description' => 'Providing home-based relaxation or therapeutic massages.'],
                    ['title' => 'Makeup Artist', 'description' => 'Providing makeup services for events or photoshoots.'],
                    ['title' => 'Tailor', 'description' => 'Altering or repairing clothes on-site.'],
                    ['title' => 'Pet Groomer', 'description' => 'Bathing, trimming, or grooming pets at home.'],
                ]
            ],
            [
                'category' => 'Small Business Support Services',
                'services' => [
                    ['title' => 'Delivery Driver', 'description' => 'Short-distance product delivery.'],
                    ['title' => 'IT/Tech Support', 'description' => 'Setting up a Wi-Fi network, troubleshooting minor tech issues.'],
                    ['title' => 'Furniture Assembly', 'description' => 'Assembling desks, chairs, or small furniture pieces'],
                    ['title' => 'Signboard Installer', 'description' => 'Installing or repairing small business signage.'],
                    ['title' => 'Office Furniture Assembly', 'description' => 'Assembling or repairing desks, chairs, or cabinets.'],
                    ['title' => 'Short-Term Security Service', 'description' => ' Providing temporary on-site security for events or establishments.'],
                ]
            ],
            [
                'category' => 'Specialty Services',
                'services' => [
                    ['title' => 'Tiler', 'description' => 'Small tiling jobs in kitchens or bathrooms.'],
                    ['title' => 'Welder', 'description' => 'Minor metal repairs, custom fittings.'],
                    ['title' => 'Glass Installer', 'description' => 'Replacing small glass panes or mirrors.'],
                ]
            ],
            [
                'category' => 'Appliance and Electronics Services',
                'services' => [
                    ['title' => 'CCTV Installer', 'description' => 'Setting up home or small business security cameras.'],
                    ['title' => 'Solar Panel Technician', 'description' => 'Cleaning and minor maintenance for solar panel systems.'],
                    ['title' => 'Audio-Visual Installer', 'description' => 'Setting up home theater systems, TVs, or projectors.'],
                ]
            ],
            [
                'category' => 'Event Support Services',
                'services' => [
                    ['title' => 'Party Setup', 'description' => 'Arranging tables, chairs, and decorations for small events.'],
                    ['title' => 'Catering Assistant', 'description' => 'Providing food service support or clean-up for small gatherings.'],
                    ['title' => 'Photographer/Videographer', 'description' => 'Capturing moments at birthdays, weddings, or corporate events.'],
                ]
            ],
            [
                'category' => 'Outdoor Services',
                'services' => [
                    ['title' => 'Fence Repair', 'description' => 'Fixing or replacing sections of fences.'],
                    ['title' => 'Pressure Washing Service', 'description' => 'Cleaning driveways, patios, or building exteriors.'],
                    ['title' => 'Tree Trimmer', 'description' => 'Trimming branches or removing small trees.'],
                ]
            ],
        ];

        // Create services in the database
        foreach ($services as $categoryData) {
            $category = ServiceCategory::where('title', $categoryData['category'])->first();

            foreach ($categoryData['services'] as $serviceData) {
                JobService::create([
                    'category_id' => $category->id,
                    'title' => $serviceData['title'],
                    'description' => $serviceData['description'],
                ]);
            }
        }
    }
}
