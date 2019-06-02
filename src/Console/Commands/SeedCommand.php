<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Console\Commands;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:testimonials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Testimonials Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => 'CortexTestimonialsSeeder']);

        $this->line('');
    }
}
