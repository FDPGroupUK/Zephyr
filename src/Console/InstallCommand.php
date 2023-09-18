<?php

namespace FDPGroupUK\Zephyr\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zephyr:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Zephyr controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        // Install Inertia...
        if (
            ! $this->requireComposerPackages(
                'inertiajs/inertia-laravel:^0.6.8',
                'laravel/sanctum:^3.2',
                'tightenco/ziggy:^1.0'
            )
        ) {
            return 1;
        }

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/vue3' => '^1.0.0',
                '@vitejs/plugin-vue' => '^4.0.0',
                '@tabler/core' => '^1.0.0-beta20',
                '@tabler/icons-vue' => '^2.0.0',
                'autoprefixer' => '^10.4.12',
                'postcss' => '^8.4.18',
                'vue' => '^3.2.41',
                'tabler-vite-vue' => '^0.1.0',
                'sass' => '^1.62.1',
            ] + $packages;
        });

        // Controllers...
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/app/Http/Controllers', app_path('Http/Controllers'));

        // Requests...
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/app/Http/Requests', app_path('Http/Requests'));

        // Middleware...
        $this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\HandleInertiaRequests::class');
        $this->installMiddlewareAfter('\App\Http\Middleware\HandleInertiaRequests::class', '\Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class');

        copy(__DIR__ . '/../../stubs/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // Views...
        copy(__DIR__ . '/../../stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));

        // Components + Pages...
        (new Filesystem())->ensureDirectoryExists(resource_path('js/Components'));
        (new Filesystem())->ensureDirectoryExists(resource_path('js/Layouts'));
        (new Filesystem())->ensureDirectoryExists(resource_path('js/Pages'));

        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/resources/js/Components', resource_path('js/Components'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/resources/js/Layouts', resource_path('js/Layouts'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/resources/js/Pages', resource_path('js/Pages'));

        // Tests...
        (new Filesystem())->ensureDirectoryExists(base_path('tests/Feature'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/tests/Feature', base_path('tests/Feature'));

        // Routes...
        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/routes/auth.php', base_path('routes/auth.php'));

        // "Dashboard" Route...
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Tailwind / Vite...
        copy(__DIR__ . '/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__ . '/../../stubs/jsconfig.json', base_path('jsconfig.json'));
        copy(__DIR__ . '/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__ . '/../../stubs/resources/js/app.js', resource_path('js/app.js'));

        // Assets
        (new Filesystem())->ensureDirectoryExists(base_path('public/assets'));
        (new Filesystem())->copyDirectory(__DIR__ . '/../../stubs/assets', base_path('public/assets'));

        // Use user's existing package manager if already found (default to npm if not found)
        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Zephyr scaffolding installed successfully.');
    }

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after . ',',
                $after . ',' . PHP_EOL . '            ' . $name . ',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return bool
     */
    protected function requireComposerPackages($packages)
    {
        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem(), function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> ' . $e->getMessage() . PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    ' . $line);
        });
    }
}
