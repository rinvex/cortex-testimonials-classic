<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Console\Commands;

use Rinvex\Testimonials\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:testimonials {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Testimonials Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $this->call('vendor:publish', ['--tag' => 'cortex-testimonials-lang', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-testimonials-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-testimonials-migrations', '--force' => $this->option('force')]);
    }
}
