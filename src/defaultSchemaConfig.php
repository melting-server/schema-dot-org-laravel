<?php

return [

	'version' => env('SCHEMA_DOT_ORG_VERSION', 'latest'),
	'isCached' => env('SCHEMA_DOT_ORG_IS_CACHED', true),
	'cacheKey' => env('SCHEMA_DOT_ORG_CACHE_KEY', 'meltingServer.schema.tree'),

];
