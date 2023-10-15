<?php

namespace Database\Seeders;

use App\Models\Model;
use App\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = Model::whereNotNull('manufacturer_id')->get();
        $models->each(function (Model $model) {
            Transport::factory()
                ->create(['model_id' => $model->id]);
        });
    }
}
