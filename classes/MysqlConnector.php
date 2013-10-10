<?php
/**
 * MysqlConnector
 */
namespace Sledgehammer;
/**
 * Use a Sledgehammer\Database object instead of a plain PDO object for Laravel mysql connections.
 * @package Laravel
 */
class MysqlConnector extends \Illuminate\Database\Connectors\MySqlConnector {

	public function createConnection($dsn, array $config, array $options) {
		$username = array_get($config, 'username');
		$password = array_get($config, 'password');
		return new Database($dsn, $username, $password, $options);
	}
}
