<?php
	class ModelCommonCity extends Model {
		public function getCityById($city_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city WHERE id = '" .(int)$city_id . "'");
			
			return $query->row;
		}
		
		public function getCities() {
				
				$city_data = array();
				
				$sql = "SELECT * FROM " . DB_PREFIX . "city c LEFT JOIN " . DB_PREFIX . "city_description cd ON (c.id = cd.city_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				
				$query = $this->db->query($sql);
				
				foreach ($query->rows as $result) {
					$city_data[$result['code']] = array(
						'id'        => $result['id'],
						'name'      => $result['name'],
						'code'      => $result['code'],
						'status'    => $result['status']
					);
				}
				
			return $city_data;

		}
		
		public function getCityDescription($code){
			
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city c LEFT JOIN " . DB_PREFIX . "city_description cd  ON (c.id = cd.city_id) WHERE code = '" . $code . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
			
		}
		
	}
