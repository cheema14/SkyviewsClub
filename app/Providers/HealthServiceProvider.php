<?php

namespace App\Providers;

use Spatie\Health\Facades\Health;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;

class HealthServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        Health::checks([
            UsedDiskSpaceCheck::new (),
            DatabaseCheck::new (),
            EnvironmentCheck::new ()->expectEnvironment('local'),
            OptimizedAppCheck::new (),
            CpuLoadCheck::new ()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            DatabaseConnectionCountCheck::new ()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            DatabaseSizeCheck::new ()
                ->failWhenSizeAboveGb(errorThresholdGb:5.0),
            DatabaseTableSizeCheck::new ()
                ->table('health_check_result_history_items', maxSizeInMb:1_000),
            DebugModeCheck::new()

        ]);
    }

}
