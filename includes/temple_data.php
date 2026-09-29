<?php
declare(strict_types=1);

function temple_image_path(int $id): string
{
    // Use direct image file paths from your `images/` folder for temples 1..8.
    // If you add/rename images, update this mapping (or tell me the desired order).
    $explicitMap = [
        1 => 'images/Chamundeshwari.webp',
        2 => 'images/Dharmasthala_Temple.jpg',
        3 => 'images/Kateel.jpg',
        4 => 'images/Kolluru.jpg',
        5 => 'images/Kukke.webp',
        6 => 'images/Murudeshwara.webp',
        7 => 'images/Polali.jpg',
        8 => 'images/shringeri.jpg',
    ];
    if (isset($explicitMap[$id])) {
        $fileOnDisk = dirname(__DIR__) . '/' . $explicitMap[$id];
        if (is_file($fileOnDisk)) {
            return $explicitMap[$id];
        }
    }

    // Prefer jpg/png/webp photos from `images/`.
    // Example expected filenames:
    // - images/temple1.webp (or .jpg / .png)
    $baseDir = dirname(__DIR__) . '/images';
    $candidates = [
        'webp',
        'jpg',
        'png',
        // Fallback for the current placeholders.
        'svg',
    ];

    foreach ($candidates as $ext) {
        $fileOnDisk = $baseDir . '/temple' . $id . '.' . $ext;
        if (is_file($fileOnDisk)) {
            return 'images/temple' . $id . '.' . $ext;
        }
    }

    // Final fallback if nothing is present.
    return 'images/temple' . $id . '.svg';
}

function get_temples(): array
{
    // Note: content is sample text. Replace with your real details anytime.
    return [
        1 => [
            'id' => 1,
            'slug' => 'temple1',
            'name' => 'Shri Chamundeshwari Temple',
            'city' => 'Mysore',
            'about' => 'The Chamundeshwari Temple is a Hindu temple located on the top of Chamundi Hills about 13 km from the palace city of Mysuru in the state of Karnataka in India.
                         The temple was named after Chamundeshwari or, the fierce form of Shakti,
                          a tutelary deity held in reverence for centuries by the Maharaja of Mysuru.',
            'colors' => ['primary' => '#f97316'],
            'image' => temple_image_path(1),
            'pooja_timings' => [
                ['label' => 'Morning', 'time' => '7:30 AM - 2:00 PM'],
                ['label' => 'Evening', 'time' => '3:30 PM - 6:00 PM'],
            ],
            'sevas' => ['Abhishekam', 'Archana', 'Aarti', 'Annadanam'],
            'hotels' => [
                ['name' => 'Lakeview Residency', 'distance' => '1.2 km'],
                ['name' => 'Heritage Inn', 'distance' => '2.4 km'],
                ['name' => 'City Comfort Hotel', 'distance' => '3.1 km'],
            ],
            'rooms' => [
                ['name' => 'Deluxe Room', 'details' => 'AC • Double Bed', 'price' => '₹3,499'],
                ['name' => 'Executive Suite', 'details' => 'AC • Living + Bedroom', 'price' => '₹5,999'],
                ['name' => 'Premium Twin', 'details' => 'AC • 2 Beds', 'price' => '₹4,299'],
            ],
        ],
        2 => [
            'id' => 2,
            'slug' => 'temple2',
            'name' => 'Shri Dharmasthala Manjunatheshwara Temple',
            'city' => 'Dharmasthala',
            'about' => 'Dharmasthala is an Indian temple town on the banks of the Nethravathi River in the taluk of Belthangady of the Dakshina Kannada 
                or southern district in Karnataka, India.
                The temple is dedicated to Lord Shiva and is known for its unique architecture and natural beauty.',
            'colors' => ['primary' => '#38bdf8'],
            'image' => temple_image_path(2),
            'pooja_timings' => [
                ['label' => 'Early Morning', 'time' => '5:30 AM - 10:30 AM'],
                ['label' => 'Noon', 'time' => '11:30 AM - 1:45 PM'],
                ['label' => 'Night Aarti', 'time' => '6:00 PM - 9:00 PM'],
            ],
            'sevas' => ['Rudrabhishekam', 'Bilva Archana', 'Maha Aarti', 'Prasad Seva'],
            'hotels' => [
                ['name' => 'Temple View Stay', 'distance' => '900 m'],
                ['name' => 'Sea Breeze Lodging', 'distance' => '2.0 km'],
                ['name' => 'Sapphire Residency', 'distance' => '2.7 km'],
            ],
            'rooms' => [
                ['name' => 'Standard Room', 'details' => 'Non-AC • Single/Double', 'price' => '₹2,299'],
                ['name' => 'AC Comfort Room', 'details' => 'AC • Double Bed', 'price' => '₹3,299'],
                ['name' => 'Family Room', 'details' => 'AC • 3 Guests', 'price' => '₹4,799'],
            ],
        ],
        3 => [
            'id' => 3,
            'slug' => 'temple3',
            'name' => 'Shri Kateel Durgaparameshwari Temple',
            'city' => 'Kateel',
            'about' => 'Kateel or Kateelu is a temple town in the Dakshina Kannada district of the Indian state of Karnataka.
                 It is considered one of the holiest Hindu temple towns in India. It is situated on the banks of the river Nandini.',
            'colors' => ['primary' => '#a78bfa'],
            'image' => temple_image_path(3),
            'pooja_timings' => [
                ['label' => 'Morning', 'time' => '6:00 AM - 12:00 PM'],
                ['label' => 'Special Pooja', 'time' => '1:00 PM - 3:00 PM'],
                ['label' => 'Evening', 'time' => '5:30 PM - 8:00 PM'],
            ],
            'sevas' => ['Kavadi Seva', 'Sahasra Archana', 'Abhishekam', 'Vasantha Pooja'],
            'hotels' => [
                ['name' => 'Garden Stay Inn', 'distance' => '1.0 km'],
                ['name' => 'Royal Comfort Suites', 'distance' => '1.8 km'],
                ['name' => 'Airport Link Hotel', 'distance' => '3.5 km'],
            ],
            'rooms' => [
                ['name' => 'Cozy Room', 'details' => 'AC • Queen Bed', 'price' => '₹3,899'],
                ['name' => 'Superior Room', 'details' => 'AC • Balcony', 'price' => '₹4,499'],
                ['name' => 'Premium Quad', 'details' => 'AC • 4 Guests', 'price' => '₹6,299'],
            ],
        ],
        4 => [
            'id' => 4,
            'slug' => 'temple4',
            'name' => 'Shri Kolluru Mookambika Temple',
            'city' => 'Kolluru',
            'about' => 'Kolluru is a temple town in the Dakshina Kannada district of the Indian state of Karnataka.
                 It is known for its temple dedicated to Goddess Mookambika.
                 The temple is located on the banks of the river Nandini.',
            'colors' => ['primary' => '#34d399'],
            'image' => temple_image_path(4),
            'pooja_timings' => [
                ['label' => 'Sunrise', 'time' => '6:00 AM - 10:00 AM'],
                ['label' => 'Afternoon', 'time' => '12:30 PM - 2:00 PM'],
                ['label' => 'Evening', 'time' => '5:00 PM - 8:00 PM'],
            ],
            'sevas' => ['Japa Seva', 'Hanuman Chalisa', 'Aarti', 'Temple Cleaning Seva'],
            'hotels' => [
                ['name' => 'Lakshmi Residency', 'distance' => '1.4 km'],
                ['name' => 'Pearl Stay Hotel', 'distance' => '2.1 km'],
                ['name' => 'Comfort & Co', 'distance' => '2.9 km'],
            ],
            'rooms' => [
                ['name' => 'Standard Double', 'details' => 'AC • Double Bed', 'price' => '₹3,099'],
                ['name' => 'Executive Room', 'details' => 'AC • Extra Space', 'price' => '₹4,199'],
                ['name' => 'Budget Twin', 'details' => 'Non-AC • 2 Beds', 'price' => '₹2,199'],
            ],
        ],
        5 => [
            'id' => 5,
            'slug' => 'temple5',
            'name' => 'Shri Subramanya swamy temple',
            'city' => 'Kukke',
            'about' => 'Kukke Subramanya is a temple town in the Dakshina Kannada district of the Indian state of Karnataka.
                 It is known for its temple dedicated to Lord Subramanya.
                 The temple is located on the banks of the river Nandini.',
            'colors' => ['primary' => '#f43f5e'],
            'image' => temple_image_path(5),
            'pooja_timings' => [
                ['label' => 'Morning', 'time' => '6:30 AM - 11:45 AM'],
                ['label' => 'Midday', 'time' => '12:15 PM - 2:45 PM'],
                ['label' => 'Evening', 'time' => '5:15 PM - 8:45 PM'],
            ],
            'sevas' => ['Durga Archana', 'Kumari Pooja', 'Aarti', 'Annadanam'],
            'hotels' => [
                ['name' => 'Riverfront Lodge', 'distance' => '1.6 km'],
                ['name' => 'Central Plaza Hotel', 'distance' => '2.3 km'],
                ['name' => 'The Temple Crown', 'distance' => '3.2 km'],
            ],
            'rooms' => [
                ['name' => 'Deluxe AC Room', 'details' => 'AC • Double Bed', 'price' => '₹3,799'],
                ['name' => 'Premium Suite', 'details' => 'AC • Suite Living', 'price' => '₹6,099'],
                ['name' => 'Family AC Room', 'details' => 'AC • 4 Guests', 'price' => '₹6,599'],
            ],
        ],
        6 => [
            'id' => 6,
            'slug' => 'temple6',
            'name' => 'Shri Murudeshwara temple',
            'city' => 'Murudeshwara',
            'about' => 'Murdeshwar is a town in Uttara Kannada district in the state of Karnataka, India, and lies on the coast of the Arabian Sea.
                It contains the worlds third tallest Shiva statue, as well as the Murudeshwara Temple. 
                The town has a railway station on the Mangalore–Mumbai Konkan railway route.
                The temple is dedicated to Lord Shiva and is known for its unique architecture and natural beauty.',
            'colors' => ['primary' => '#60a5fa'],
            'image' => temple_image_path(6),
            'pooja_timings' => [
                ['label' => 'Early', 'time' => '5:45 AM - 10:45 AM'],
                ['label' => 'Lunch Pooja', 'time' => '11:15 AM - 2:00 PM'],
                ['label' => 'Bhajan Night', 'time' => '6:30 PM - 9:15 PM'],
            ],
            'sevas' => ['Govind Nam', 'Gita Parayana', 'Mangala Aarti', 'Prasad Seva'],
            'hotels' => [
                ['name' => 'Connaught Comfort', 'distance' => '1.1 km'],
                ['name' => 'Heritage Avenue', 'distance' => '2.5 km'],
                ['name' => 'Modern Stay Inn', 'distance' => '3.3 km'],
            ],
            'rooms' => [
                ['name' => 'Standard Room', 'details' => 'AC • Double Bed', 'price' => '₹3,199'],
                ['name' => 'Business Room', 'details' => 'AC • Work Desk', 'price' => '₹4,399'],
                ['name' => 'Royal Suite', 'details' => 'AC • King Bed', 'price' => '₹7,199'],
            ],
        ],
        7 => [
            'id' => 7,
            'slug' => 'temple7',
            'name' => 'Shri Polali Rajarajeswari Temple',
            'city' => 'Polali',
            'about' => 'Polali Rajarajeshwari Temple is a temple located in Polali, Dakshina Kannada district in Karnataka.
                The primary deity of the temple is Shri Rajarajeshwari. 
                The temple was constructed in the 8th century AD by King Suratha and has been developed by many dynasties which ruled over the region. ',
            'colors' => ['primary' => '#f59e0b'],
            'image' => temple_image_path(7),
            'pooja_timings' => [
                ['label' => 'Morning', 'time' => '6:00 AM - 11:00 AM'],
                ['label' => 'Afternoon', 'time' => '12:00 PM - 2:30 PM'],
                ['label' => 'Evening', 'time' => '4:45 PM - 8:30 PM'],
            ],
            'sevas' => ['Sai Samarpan', 'Aarti', 'Bhajan Seva', 'Sai Prasad'],
            'hotels' => [
                ['name' => 'Deccan View Hotel', 'distance' => '1.3 km'],
                ['name' => 'Star Residency', 'distance' => '2.0 km'],
                ['name' => 'Cityline Suites', 'distance' => '3.0 km'],
            ],
            'rooms' => [
                ['name' => 'Comfort Room', 'details' => 'AC • Queen Bed', 'price' => '₹3,499'],
                ['name' => 'Deluxe Room', 'details' => 'AC • Extra Storage', 'price' => '₹4,299'],
                ['name' => 'Premium Family Room', 'details' => 'AC • 4 Guests', 'price' => '₹6,399'],
            ],
        ],
        8 => [
            'id' => 8,
            'slug' => 'temple8',
            'name' => 'Shringeri Sharadamba Temple',
            'city' => 'Shringeri',
            'about' => 'Sringeri also called Shringeri is a hill town and Taluk headquarters located in Chikkamagaluru district in the Indian state of Karnataka.
                    Sringeri is the site of Sri Sharadamba temple, a part of the Sringeri Sharada Peetham established by Adi Shankaracharya. ',
            'colors' => ['primary' => '#22c55e'],
            'image' => temple_image_path(8),
            'pooja_timings' => [
                ['label' => 'Morning', 'time' => '6:00 AM - 11:30 AM'],
                ['label' => 'Afternoon', 'time' => '12:00 PM - 2:15 PM'],
                ['label' => 'Evening', 'time' => '5:30 PM - 8:45 PM'],
            ],
            'sevas' => ['Suprabhata Seva', 'Archana', 'Aarti', 'Vahana Seva'],
            'hotels' => [
                ['name' => 'Temple Residency', 'distance' => '850 m'],
                ['name' => 'Hillview Comfort', 'distance' => '2.2 km'],
                ['name' => 'Grand Heritage Hotel', 'distance' => '3.6 km'],
            ],
            'rooms' => [
                ['name' => 'Temple View Room', 'details' => 'AC • Double Bed', 'price' => '₹4,099'],
                ['name' => 'Premium Suite', 'details' => 'AC • Family Suite', 'price' => '₹6,999'],
                ['name' => 'Standard Twin', 'details' => 'Non-AC • 2 Beds', 'price' => '₹2,599'],
            ],
        ],
    ];
}

