<?php

namespace Database\Seeders;

use App\Models\Model;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    private array $data = [
        [
            'name' => 'Audi',
            'models' => [
                [
                    'name' => '100',
                ],
                [
                    'name' => 'a4',
                ],
                [
                    'name' => 'a5',
                ],
                [
                    'name' => 'a6',
                ],
                [
                    'name' => 'a7',
                ],
                [
                    'name' => 'a8',
                ],
            ],
        ],
        [
            'name' => 'BMW',
            'models' => [
                [
                    'name' => '1 serija',
                ],
                [
                    'name' => '2 serija',
                ],
                [
                    'name' => '3 serija',
                ],
                [
                    'name' => '4 serija',
                ],
                [
                    'name' => '5 serija',
                ],
                [
                    'name' => '6 serija',
                ],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacturers = Model::withTrashed()->whereNull('manufacturer_id')->get()->groupBy('name');

        foreach ($this->data as $row) {
            $values = $manufacturers->get($row['name']);

            if (!$values) {
                $manufacturer = Model::create([
                    'name' => $row['name'],
                ]);
                $this->updateModels($manufacturer, $row['models']);

                continue;
            }

            $value = $values->first();
            $this->updateModels($value, $row['models']);

            if ($value->trashed()) {
                $value->restore();
            }
        }
    }

    private function updateModels(Model $manufacturer, array $models): void
    {
        $allModels = Model::withTrashed()
            ->where('manufacturer_id', $manufacturer->id)
            ->get()
            ->groupBy('name');

        foreach ($models as $row) {
            $values = $allModels->get($row['name']);

            if (!$values) {
                Model::create([
                    'name' => $row['name'],
                    'manufacturer_id' => $manufacturer->id,
                ]);

                continue;
            }

            $value = $values->first();

            if ($value->trashed()) {
                $value->restore();
            }
        }
    }
}
