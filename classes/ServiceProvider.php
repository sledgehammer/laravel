<?php
/**
 * ServiceProvider
 */
namespace Sledgehammer;
use Config;
use Illuminate\Database\MySqlConnection;
/**
 * @package Laravel
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider {
 
	public function register() {

		restore_error_handler();

		// Enabling Sledgehammer\Database for migrations would cause "Table 'migrations' already exists" exceptions.
		if (empty($GLOBALS['argv']) || strpos(implode($GLOBALS['argv']), 'migrate') === false) { 
			$this->injectDatabase();
		}
	}

	/**
	 * Inject the Sledgehammer Database class
	 */
	protected function injectDatabase() {
		$databaseManager = $this->app->make('db');
		$app = $this->app;
		$databaseManager->extend('mysql', function ($config) use ($app){
			$connector = new MysqlConnector();
			$pdo = $connector->connect($config);
			$default = Config::get('database.default');
			$defaultConfig = Config::get('database.connections.'.$default);
			if ($defaultConfig === $config) { 
				// Register the database connection for use in Sledgehammer code.
				Database::$instances[$default] = $pdo;
				Database::$instances['default'] = $default;
				// Rename the logger to 'Database'
				foreach (Logger::$instances as $name => $logger) {
					if ($pdo->logger === $logger) {
						$loggerName = 'Database';
						if (empty(Logger::$instances[$loggerName])) {
							Logger::$instances[$loggerName] = $logger;
							unset(Logger::$instances[$name]);
						}
						break;
					}
				}
			}
			return new MySqlConnection($pdo);
		});
	}
	
}