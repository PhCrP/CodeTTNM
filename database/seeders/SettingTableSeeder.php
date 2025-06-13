<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Ngoại trừ việc tội lỗi không xảy ra thường xuyên, đó là lý do tại sao bạn không thể làm được điều đó.",
            'short_des'=>"Đó là một món quà, không phải là một con đường đầy ánh sáng, cũng không phải là gánh nặng.",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"NO. 123 - HaNoi , 012 Kingdom",
            'email'=>"eshop@gmail.com",
            'phone'=>"+84 123 456 789",
        );
        DB::table('settings')->insert($data);
    }
}
