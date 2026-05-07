<?php

use Illuminate\Database\Seeder;
use App\ProductionRecord;
use Carbon\Carbon;

class ProductionRecordSeeder extends Seeder
{
    public function run()
    {
        $lines = ['Geladeira', 'Máquina de Lavar', 'TV', 'Ar-Condicionado'];

        foreach ($lines as $line) {
            for ($day = 1; $day <= 31; $day++) {
                $produced = rand(850, 1500);
                $defects = rand(10, 90);

                ProductionRecord::create([
                    'product_line' => $line,
                    'production_date' => Carbon::create(2026, 1, $day)->format('Y-m-d'),
                    'quantity_produced' => $produced,
                    'quantity_defects' => $defects,
                ]);
            }
        }
    }
}
