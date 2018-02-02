<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Console\Commands;

use Rinvex\Testimonials\Console\Commands\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:testimonials {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Testimonials Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->call('migrate:reset', ['--path' => 'app/cortex/testimonials/database/migrations', '--force' => $this->option('force')]);

        parent::handle();
    }
}
