<?php

namespace Database\Seeders;

use App\Models\ProductCodeEmblishments;
use App\Models\ProductCodeFinishing;
use App\Models\ProductCodeItemDetail;
use App\Models\ProductCodeMakers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data1 = ['ER','ET','ED','EC','EB','EH','SP','TP','EB','JH','NP','SP','NR','NT','PD','PS','CH','NK','NC','NT','WR','BG','BT','FR','CR','TR','DR','FN','HP','BR','TR','AN','PL','CB','KB'];

        // $data2 = ['Ear Rings','Ear Tops','Ear Dangler','Ear Cuff','Ear Bugadi','Ear Hoops','Second Piercing','Third Piercing','Ear Bali','Jhumka','Nose Pin','Septum','Nose Rings','Nathni','Pendant','Pendant Sets','Chokers','Necklace','Neck Chains','Necklace Temple Designs','Wrislet','Bangles','Bangles Temple Designs','Finger Rings','Cocktail Rings','Temple Design Rings','Designer Ring','Finger Nails','Hair Pin','Brooch','Toe Rings','Anklets','Payels','Cuff Buttons','Kurta Buttons'];

        // for($i=0;$i<35;$i++){
        //     ProductCodeItemDetail::create([
        //       'prefix'=>$data1[$i],
        //       'item_name'=>$data2[$i]
        //     ]);
        //  }
        
        // $data3 =['AD','PR','KN','CS','MN','CH','BD','TS'];
        // $data4 =['American Diamond','Pearl','Kundan','Color Stone','Meenakari','Chilai Work','Bandhni','Tussle'];

        // for($i=0;$i<8;$i++){
        //     ProductCodeEmblishments::create([
        //        'prefix'=>$data3[$i],
        //        'emblishment_name'=>$data4[$i]
        //     ]);
        // }


        // $data5 = ['RH','GL','RG','OX','MG','AG','MS'];
        // $data6 =['Rhodium Polish','Gold Plated','Rose Gold','Oxidised','Mat Gold','Antique Gold','Mat Silver'];

        // for($i=0;$i<7;$i++){
        //    ProductCodeFinishing::create([
        //        'prefix'=>$data5[$i],
        //        'finishing_name'=>$data6[$i]
        //    ]);
        // }

        // $data7 =['CH','DP','JP','PR','SK'];
        // $data8 =['Chiranjeet','Dipak','Jaipur','Parekh','Sukumar'];
         
        // for($i=0;$i<5;$i++){
        //     ProductCodeMakers::create([
        //         'prefix'=> $data7[$i],
        //         'makers_name'=> $data8[$i],
        //     ]);
        // }
    }
}
