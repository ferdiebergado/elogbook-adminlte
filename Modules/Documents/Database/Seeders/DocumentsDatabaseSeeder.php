<?php

namespace Modules\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DocumentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(DoctypesTableSeeder::class);
        $this->call(StrandsCsvSeeder::class);
        $this->call(BureauservicesCsvSeeder::class);
        $this->call(OfficesCsvSeeder::class);

        // factory(\Modules\Documents\Entities\Document::class, 10)->states('office_all_user')->create();

        // factory(\Modules\Documents\Entities\Document::class, 10)->states('office_all_nonuser')->create();

        // factory(\Modules\Documents\Entities\Document::class, 10)->states('office_mix1')->create();

        // factory(\Modules\Documents\Entities\Document::class, 10)->states('office_mix2')->create();

        factory(\Modules\Documents\Entities\Transaction::class, 10)->states('user')->create();

        factory(\Modules\Documents\Entities\Transaction::class, 10)->states('mix1')->create();

        factory(\Modules\Documents\Entities\Transaction::class, 10)->states('nonuser')->create();        

        factory(\Modules\Documents\Entities\Transaction::class, 10)->states('mix2')->create();
    }
}
