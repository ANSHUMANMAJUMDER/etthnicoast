<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomeCustomerReview;
class HomeReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
   $reviews = [
            [
                'user_id'       => 1,
                'customer_name' => 'Anjali Patel',
                'rating'        => 5,
    
                'review'        => 'Best silver jewelry store! Great customer service and authentic products. Love my new necklace! The packaging was beautiful too.',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Rahul Sharma',
                'rating'        => 5,
         
                'review'        => 'Amazing quality and beautiful designs. The pieces are exactly as shown on the website. Highly recommend Etthnicoast to everyone!',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Vikram Singh',
                'rating'        => 5,
             
                'review'        => 'Perfect gift for my wife. She absolutely loved the earrings. Will definitely shop again from this store!',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Priya Mehta',
                'rating'        => 4,

                'review'        => 'Very happy with my purchase. The ring fits perfectly and the silver quality is excellent. Delivery was quick too.',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Sneha Kapoor',
                'rating'        => 5,
            
                'review'        => 'I ordered a bracelet set and it arrived in the most gorgeous gift box. The craftsmanship is top notch. Already placed a second order!',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Arjun Nair',
                'rating'        => 4,
      
                'review'        => 'Good quality 925 silver. The oxidised finish on the pendant looks even better in person. Packaging is premium and gift-ready.',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Divya Reddy',
                'rating'        => 5,

                'review'        => 'Ordered the stackable ring set as a birthday gift. My friend was absolutely thrilled. The quality is outstanding for the price!',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Karan Malhotra',
                'rating'        => 5,

                'review'        => 'Bought a men\'s silver bracelet and I get compliments every time I wear it. Very sturdy and genuine 925 silver. Great brand!',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Meera Iyer',
                'rating'        => 4,
  
                'review'        => 'Lovely collection and easy website to navigate. The anklet I purchased is delicate and well-made. Will shop again for sure.',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Rohan Joshi',
                'rating'        => 3,
      
                'review'        => 'Overall decent product. The delivery took a bit longer than expected but the quality of the ring is good. Would give it another try.',
                'is_active'     => false,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Nisha Gupta',
                'rating'        => 5,
        
                'review'        => 'Absolutely in love with my moonstone ring! It looks magical and the silver setting is flawless. Etthnicoast never disappoints.',
                'is_active'     => true,
            ],
            [
                'user_id'       => 1,
                'customer_name' => 'Aditya Verma',
                'rating'        => 5,

                'review'        => 'Gifted a pendant set to my mother on her anniversary and she was over the moon. Beautiful pieces, fast shipping, excellent service!',
                'is_active'     => true,
            ],
        ];

        foreach ($reviews as $data) {
            HomeCustomerReview::create($data);
        }

        $this->command->info('✅  HomeCustomerReview seeder completed — ' . count($reviews) . ' records inserted.');
    }
}
