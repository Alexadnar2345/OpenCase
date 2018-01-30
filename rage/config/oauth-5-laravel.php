<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Vkontakte' => [
			'client_id'     => '4315658',
			'client_secret' => 'AGYwnlvXLLOYWEGXcO4G',
			'scope'         => ['friends', 'photos', 'wall', 'groups'],
		],

	]

];