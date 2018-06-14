<?php
	class ModelCommonCity extends Model {
		public function getCityById($city_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city WHERE id = '" .(int)$city_id . "'");
			
			return $query->row;
		}
		
		public function getCities() {
			
			$city_data = $this->cache->get('city');
			
			if (!$city_data) {
				$city_data = array();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city ORDER BY name ASC");
				
				foreach ($query->rows as $result) {
					$city_data[$result['code']] = array(
						'id'        => $result['id'],
						'name'      => $result['name'],
						'code'      => $result['code'],
					);
				}
				
				$this->cache->set('city', $city_data);
			}
			
			return $city_data;

		}
		
	}
