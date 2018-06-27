<?php
	class ModelCommonCity extends Model {
		
		public function addCity($data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "city SET code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "', robots = '" . (int)$data['robots'] . "'");
			
			$city_id = $this->db->getLastId();
			
			foreach ($data['city_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "city_description SET city_id = '" . (int)$city_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "'");
			}
			
			$this->cache->delete('city');
			
			return $city_id;
		}
		
		public function editCity($city_id, $data) {
			$this->db->query("UPDATE " . DB_PREFIX . "city SET code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "', robots = '" . (int)$data['robots'] . "' WHERE id = '" . (int)$city_id . "'");
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
			
			foreach ($data['city_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "city_description SET city_id = '" . (int)$city_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "'");
			}
			
			$this->cache->delete('city');
		}
		
		public function getCities($data = array()) {
			
				if ($data) {
					$sql = "SELECT * FROM " . DB_PREFIX . "city c LEFT JOIN " . DB_PREFIX . "city_description cd ON (c.id = cd.city_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
					
					$sort_data = array(
						'name'
					);
					
					if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
						$sql .= " ORDER BY " . $data['sort'];
					} else {
						$sql .= " ORDER BY name";
					}
					
					if (isset($data['order']) && ($data['order'] == 'DESC')) {
						$sql .= " DESC";
					} else {
						$sql .= " ASC";
					}
					
					if (isset($data['start']) || isset($data['limit'])) {
						if ($data['start'] < 0) {
							$data['start'] = 0;
						}
						
						if ($data['limit'] < 1) {
							$data['limit'] = 20;
						}
						
						$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
					}
					
					$query = $this->db->query($sql);
					
					return $query->rows;
				}
				
					$city_data = array();
					
					$sql = "SELECT * FROM " . DB_PREFIX . "city c LEFT JOIN " . DB_PREFIX . "city_description cd ON (c.id = cd.city_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
					
					$query = $this->db->query($sql);
					
					foreach ($query->rows as $result) {
						$city_data[$result['id']] = array(
							'id' => $result['id'],
							'name' => $result['name'],
							'code' => $result['code'],
							'status' => $result['status']
						);
					}
				
				return $city_data;
		}
		
		public function getUrlAlias($keyword) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE code = '" . $this->db->escape($keyword) . "'");
			
			return $query->row;
		}
		
		public function getCityDescriptions($city_id) {
			$city_description_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
			
			foreach ($query->rows as $result) {
				$city_description_data[$result['language_id']] = array(
					'name'             => $result['name'],
					'title'            => $result['title'],
					'description'      => $result['description'],
					'meta_h1'          => $result['meta_h1'],
					'meta_description' => $result['meta_description']
				);
			}
			
			return $city_description_data;
		}
		
		public function deleteCity($city_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE id = '" . (int)$city_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_city WHERE city_id = '" . (int)$city_id . "'");
			
			$this->cache->delete('city');
		}
		
		public function getTotalCities() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "city");
			
			return $query->row['total'];
		}
		
		public function getCity($city_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city WHERE id = '" . (int)$city_id . "'");
			
			return $query->row;
		}
		
	}
