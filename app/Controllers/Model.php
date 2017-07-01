<?php
 
namespace Controllers;

/**
 * Base class controlls writing object data to database and reading from it
 * 
 * @author Toms Teteris
 */
class Model {
	
	private $_table;
	private $_rules;
	
	/**
	 * Default constructor - generates table name so later that uses less resources
	 */
	public function __construct() {
		$this->_table = Model::generateTableName();
	}
	
	/**
	 * This function saves object to database
	 */
	public function save() {
		$sql = "INSERT INTO `" . $this->_table . "` ";
		$vars = get_object_vars($this);
		$dbVars = [];
		
		// remove empty values and model specific variables
		foreach ($vars as $key => $value) {
			if (empty($value)) {
				unset($vars[$key]);
			}
						
			if (strpos($key, '_') === 0) {
				unset($vars[$key]);
			}
		}
		
		// convert to mysql friendly keys and values
		foreach ($vars as $key => $val) {
			$k = $this->filterToDb($key);
			switch($this->_rules[$k]) {
				case "integer":
					$v = intval($val);
					break;
				case "double":
				case "float":
					$v = number_format($val);
					break;
				case "timestamp":
					if (is_object($val)) {
						/** \DateTime $val */
						$v = $val->getTimestamp();
						break;
					}
					$v = intval($val);
				case "datetime":
					if (is_object($val)) {
						/** \DateTime $val */
						$v = $val->format('Y-m-d H:i:s');
						break;
					}
					$date = new \DateTime();
					$date->setTimestamp($val);
					$v = $date->format('Y-m-d H:i:s');
					break;
				case "string":
				default:
					$v = "'" . $val . "'";
			}
			
			$dbVars[$k] = $v ; 
		}

		// convert to strings for query
		$columns = '(`'. implode('`,`', array_keys($dbVars)) . '`)';
		$values = ' VALUES (' . implode(',', array_values($dbVars)) . ')';
		
		$sql .= $columns . $values;
				
		// insert and set id for this object from db
		$this->id = DatabaseController::query($sql, get_class($this));
	}
	
	/**
	 * Returns one object of called class
	 * 
	 * @param integer $id
	 * @return null | object
	 */
	public static function getById($id) {
		$objects = DatabaseController::query('SELECT * FROM ' . self::generateTableName() . ' WHERE id = ' . $id, get_called_class());
		
		if (is_array($objects)) {
			$object = $objects[0];
			if (count($objects) > 1) {
				error_log('<warning> Multiple results fetched when expected one [' . get_called_class() . ' | amount: ' . count($objects));
			}
		} else if ($objects == null) {
			return null;
		} else {
			$object = $objects;
		}
		
		return Model::fetchFix($object);
	}
	
	/**
	 * Returns all objects of called type from database
	 * 
	 * @return null | object[]
	 */
	public static function getAll() {
		$objects = DatabaseController::query('SELECT * FROM ' . self::generateTableName(), get_called_class());
		
		if (!is_array($objects)) {
			$objects[] = $objects;
		}
		
		foreach ($objects as $object) {
			$object = Model::fetchFix($object);
		}
		
		return $objects;
	}
	
	/**
	 * Retruns variables except Model class specified variables
	 * 
	 * @param Model $object
	 * @return array
	 */
	private function getModelVars(Model $object) {
		$vars = get_object_vars($object);
		
		foreach ($vars as $key => $value) {
			if (strpos($key, '_') === 0) {
				unset($vars[$key]);
			}
		}
		
		return $vars;
	}
	
	/**
	 * Convert variable names to snakecase for writing to database
	 * 
	 * @param string $name
	 * @return string
	 */
	private function filterToDb($name) {
		return strtolower(preg_replace('/(?<=[^A-Z]{1})([A-Z]{1})/' ,  '_$1', $name));
	}
	
	/**
	 * Convert variable names to camel case for using in php
	 * 
	 * @param string $name
	 * @return mixed
	 */
	private function filterToClass($name) {
		return preg_replace_callback(
			'/(_[a-z]{1})/',
			function ($match) {
				return strtoupper($match[0][1]);
			},
			$name);
	}
	
	/**
	 * Generates table name from class name
	 * 
	 * @return string
	 */
	private function generateTableName() {
		$name = explode('\\' , get_called_class());
		$name =  $name[count($name)-1];
		$name = self::filterToDb($name);
		return $name . 's';
	}
	
	/**
	 * Fix object before retrieving to user - change autofetched object parameter names to camelcase
	 * 
	 * @param Model $object
	 * @return Model
	 */
	private function fetchFix(Model $object) {
		$vars = Model::getModelVars($object);
		foreach ($vars as $key => $value) {
			if (strpos($key, '_') !== false) {
				$object->{Model::filterToClass($key)} = $value;
				unset($object->{$key});
			}
		}
		return $object;
	}
	
	/**
	 * Add variable types for object parameters
	 * 
	 * @param array $rules
	 */
	public function setParameterRules($rules) {
		$this->_rules = $rules;
	}
}