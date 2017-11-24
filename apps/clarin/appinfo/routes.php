<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Clarin\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
//	    ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
//	    ['name' => 'page#do_echo', 'url' => '/echo', 'verb' => 'POST'],
//    	['name' => 'ws#zip', 'url' => '/zip', 'verb' => 'POST'],
		// dSpace entries
		['name' => 'DSpace#zipdspace', 'url' => '/zip-dspace', 'verb' => 'POST'],
		['name' => 'DSpace#exporttodspace', 'url' => '/dspace_export', 'verb' => 'POST'],

		// ws entries
		['name' => 'ws#ccl', 'url' => '/ccl', 'verb' => 'POST'],
		['name' => 'ws#watchfile', 'url' => '/watchfile', 'verb' => 'POST'],

		// inforex entries
		['name' => 'inforex#export', 'url' => '/inforex_export', 'verb' => 'POST'],
    ]
];
