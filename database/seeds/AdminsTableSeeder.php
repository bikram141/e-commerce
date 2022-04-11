<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords=[
            ['id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'7064155716',
            'email'=>'admin@admin.com','password'=>'$2y$10$h8Uw0nIOny.G5g29RkD5XuFs0J2WHfopGpHaohGG0fffkmTc1JLJe','image'=>'','status'=>1],
        
    ];
    DB::table('admins')->insert($adminRecords);
    // foreach($adminRecords as $key =>$record){
    //     \App\Admin::create($record);
    // }
        
    }
}
