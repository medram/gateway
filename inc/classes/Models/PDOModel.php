<?php

namespace MR4Web\Models;

use MR4Web\Connections\DB;

abstract class PDOModel {

	private static $pdo;
	private $fields = array();

	public static function getPDO() {
		if (!isset(self::$pdo)) {
			/*self::$pdo = new PDO(
				'mysql:dbname=' . Config::DB . ';host=' . Config::HOST,
				Config::USER,
				Config::PASS
			);*/
			self::$pdo = &DB::getInstance();
			self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
		}
		return self::$pdo;
	}
	
	protected static function getModelName($withNamespace = true) {
		if ($withNamespace)
			return strtolower(get_called_class());
		else
			return strtolower(end(explode('\\',get_called_class())));
	}
	
	protected static function getTableName() {
		return '`'.self::getModelName(false) . 's`';
	}
	
	protected static function getFieldName($field) {
		//return self::getModelName() . '_' . $field;
		return '`'.$field.'`';
	}
	
	protected static function getBindName($field) {
		return ":{$field}";
	}
	
	protected static function getPropertyName($prop) {
		//return substr($prop, strlen(self::getModelName()) + 1);
		return $prop;
	}
	
	public static function getLastInsertId(){
		return self::$pdo->lastInsertId();
	} 

	public static function get($id) {
		return self::getBy(['id' => $id]);
	}
	
	public static function getBy($where = NULL, array $orderBy = [], $start = 0, $limit = 0) {
		$result = self::getAllBy($where, $orderBy, 0, 1);
		if (count($result))
			return $result[0];
		return NULL;
	}

	public static function getAll(array $orderBy = [], $start = 0, $limit = 0) {
		return self::getAllBy(NULL, $orderBy, $start, $limit);
	}
	
	public static function getAllBy($where = NULL, array $orderBy = [], $start = 0, $limit = 0) {
		
		$tableName = self::getTableName();
		$q = "SELECT * FROM {$tableName} ";

		if (!is_null($where))
		{
			if (is_array($where) && count($where))
			{
				$q .= "WHERE ";
				$i = 0;
				foreach ($where as $field => $value)
				{
					$fieldName = self::getFieldName($field);
					$bindName = self::getBindName($field);
					$q .= "{$fieldName}={$bindName} ";
					if (count($where)-1 != $i)
						$q .= " AND ";
					++$i;
				}
			}
			else
			{
				$q .= $where;
			}
		}

		if (count($orderBy))
		{
			$orderField = self::getFieldName($orderBy[0]);
			$q .= "ORDER BY {$orderField} {$orderBy[1]} ";
		}

		if ($limit)
		{
			$q .= "LIMIT {$start}, {$limit}";
		}

		$sth = self::getPDO()->prepare($q);

		if (is_array($where) && count($where))
		{
			foreach ($where as $field => $value)
			{
				$bindName = self::getBindName($field);
				$sth->bindValue($bindName, $value);
			}
		}

		$sth->execute();
		$data = $sth->fetchAll(\PDO::FETCH_ASSOC);
		//echo $sth->queryString.'<br>';
		if ($data) {
			$models = array();
			foreach ($data as $d) {
				$modelName = self::getModelName();
				$models[] = new $modelName($d);
			}
			return $models;
		}
		return [];
	}
	
	public function __construct($schema, $data = false) {
		$this->fields['id'] = array('value' => null, 'type' => \PDO::PARAM_INT);
		foreach ($schema as $name => $type) {
			$this->fields[$name] = array('value' => null, 'type' => $type);
		}
		if ($data) {
			foreach ($data as $column => $value) {
				$prop = self::getPropertyName($column);
				$this->fields[$prop]['value'] = $value;
			}
		}
	}

	public function save() {
		$tableName = self::getTableName();
		if ($this->fields['id']['value'] != null) {
			foreach ($this->fields as $field => $f) {
				if ($field != 'id' && $f['value'] != null) {
					$fieldName = self::getFieldName($field); 
					$bindName = self::getBindName($field);
					$fields[] = "{$fieldName} = {$bindName}";
				}
			}
			$fieldName = self::getFieldName('id');
			$bindName = self::getBindName('id');
			$set = implode(', ', $fields);
			$q = "UPDATE {$tableName} ";
			$q .= "SET {$set} ";
			$q .= "WHERE {$fieldName} = {$bindName}";
		} else {
			$cols = [];
			$binds = [];
			foreach ($this->fields as $field => $f) {
				if ($field != 'id' && $f['value'] != null) {
					$cols[] = self::getFieldName($field);
					$binds[] = self::getBindName($field);
				}
			}
			$columns = implode(', ', $cols);
			$bindings = implode(', ', $binds);

			$q = "INSERT INTO {$tableName} ";
			$q .= "({$columns}) VALUES ({$bindings})";
		}
		//$sth = ModelPDO::getPDO()->prepare($q);
		$sth = self::getPDO()->prepare($q);
		//echo "{$sth->queryString}<br>";
		foreach ($this->fields as $field => $f) {
			$value = $f['value'];
			if ($f['value'] != null) {
				$sth->bindValue(self::getBindName($field), $f['value'], $f['type']); 
			}
		}
		return $sth->execute();
	}

	public function delete() {
		return self::deleteBy(['id' => $this->fields['id']['value']]);
		
/*		$tableName = self::getTableName();
		if ($this->fields['id']['value'] != null) {
			$fieldName = self::getFieldName('id');
			$bindName = self::getBindName('id');
			$q = "DELETE FROM {$tableName} ";
			$q .= "WHERE {$fieldName} = {$bindName}";

			$sth = self::getPDO()->prepare($q);
			$sth->bindValue($bindName, $this->fields['id']['value'], $this->fields['id']['type']); 
			//echo "{$sth->queryString}\n";
			return $sth->execute();
		}
		return false;*/
	}

	public static function deleteBy(array $where)
	{
		$tableName = self::getTableName();
		$q = "DELETE FROM {$tableName} ";
		$q .= "WHERE ";
		
		$i = 0;
		foreach ($where as $key => $value)
		{		
			$fieldName = self::getFieldName($key);
			$bindName = self::getBindName($key);
			$q .= "{$fieldName} = {$bindName} ";
			if ($i != count($where)-1)
				$q .= " AND ";
		}

		$sth = self::getPDO()->prepare($q);

		foreach ($where as $key => $value)
		{
			$bindName = self::getBindName($key);
			$sth->bindValue($bindName, $value); 
		}

		//echo "{$sth->queryString}\n";
		if ($sth->execute())
			return true;
		return false;		
	}

	public function __set($name, $value) {
		if (array_key_exists($name, $this->fields)) {
			$this->fields[$name]['value'] = $value;
		}
	}
	
	public function __get($name) {
		if (array_key_exists($name, $this->fields)) {
			return stripslashes($this->fields[$name]['value']);
		}
	}
}

?>