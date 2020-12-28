<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Database\Seeders;

use Illuminate\Database\Seeder;

class CortexTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List testimonials', 'entity_type' => 'testimonial'],
            ['name' => 'import', 'title' => 'Import testimonials', 'entity_type' => 'testimonial'],
            ['name' => 'create', 'title' => 'Create testimonials', 'entity_type' => 'testimonial'],
            ['name' => 'update', 'title' => 'Update testimonials', 'entity_type' => 'testimonial'],
            ['name' => 'delete', 'title' => 'Delete testimonials', 'entity_type' => 'testimonial'],
            ['name' => 'audit', 'title' => 'Audit testimonials', 'entity_type' => 'testimonial'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
