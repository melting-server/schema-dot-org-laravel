<?php


namespace Schema;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use SchemaDotOrgTree\Tree;

class SchemaServiceProvider extends ServiceProvider implements DeferrableProvider {
	public function boot() {
		$this->publishes([
			__DIR__.'/defaultSchemaConfig.php' => config_path('schema.php'),
		]);
	}

	public function register() {
		$this->app->singleton(Tree::class, function ($app) {
			$isCached = config('schema.isCached', true);
			$cacheKey = config('schema.cacheKey', 'meltingServer.schema.tree');
			$version = config('schema.version', 'latest');
			if(!$isCached) {
				$tree = new Tree($version);
				return $tree;
			}
			if(Cache::has($cacheKey)) {
				return Cache::get($cacheKey);
			}
			$tree = new Tree($version);
			Cache::put($cacheKey, $tree, now()->addYears(999));
			return $tree;
		});
	}

	public function provides()
	{
		return [Tree::class];
	}

}