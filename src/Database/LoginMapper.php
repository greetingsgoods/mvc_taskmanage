<?php

namespace Local\Database;


class LoginMapper
{
	private $pdo;

	/**
	 * LoginMapper constructor.
	 * @param \PDO $pdo
	 */
	function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * @param int $loginID
	 * @return bool
	 * @throws \Exception
	 */
	function getHash($loginID)
	{
		try {
			$sql = 'SELECT `token` FROM `local_logins` WHERE `id` = :id';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':id', $loginID, \PDO::PARAM_INT);
			$result = $stmt->execute();
			if ($result !== false) {
				$assoc = $stmt->fetch(\PDO::FETCH_ASSOC);
				if (is_array($assoc)) {
					$result = $assoc['token'];
				} else $result = false;
			}
		} catch (\PDOException $e) {
			throw new \Exception('Ошибка при получении хэша.', 0, $e);
		}
		return $result;
	}

	/**
	 * @param int $loginID
	 * @return bool
	 * @throws \Exception
	 */
	function getUserID($loginID)
	{
		try {
			$sql = 'SELECT `userid` FROM `local_logins` WHERE `id` = :id';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':id', $loginID, \PDO::PARAM_INT);
			$result = $stmt->execute();
			if ($result !== false) {
				$assoc = $stmt->fetch(\PDO::FETCH_ASSOC);
				if (is_array($assoc)) {
					$result = $assoc['userid'];
				} else $result = false;
			}
		} catch (\PDOException $e) {
			throw new \Exception('Ошибка при получении ID пользователя.', 0, $e);
		}
		return $result;
	}

	/**
	 * @param string $token
	 * @param int $userid
	 * @return bool|int
	 * @throws \Exception
	 */
	function addLogin($token, $userid)
	{
		try {
			$sql = 'INSERT INTO `local_logins`(`token`, `userid`) VALUES (:token, :userid)';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':token', $token);
			$stmt->bindParam(':userid', $userid);
			$result = $stmt->execute();
			if (($result !== false) and ($this->lastInsertedId() !== 0)) {
				$result = $this->lastInsertedId();
			} else {
				$result = false;
			}
		} catch (\PDOException $e) {
			throw new \Exception('Ошибка при добавлении записи о логине.', 0, $e);
		}
		return $result;
	}

	/**
	 * Имеет смысл использовать только следующим же выражением после insert.
	 *
	 * @return int id of last inserted ID or 0 if cannot retrieve
	 */
	public function lastInsertedId()
	{
		return (int)$this->pdo->lastInsertId();
	}

	function deleteLoginsOfUser($userid)
	{
		try {
			$sql = 'DELETE FROM `local_logins` WHERE `userid` = :userid';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':userid', $userid, \PDO::PARAM_INT);
			$result = $stmt->execute();
		} catch (\PDOException $e) {
			throw new \Exception('Ошибка при удалении логинов пользователя.', 0, $e);
		}
		return $result;
	}
}
