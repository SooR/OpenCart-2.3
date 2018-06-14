<?php
	class ModelCommonCity extends Model {
		
		public function addCity($data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "city SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "'");
			
			$city_id = $this->db->getLastId();
			
			$this->cache->delete('city');
			
			return $city_id;
		}
		
		public function editCity($city_id, $data) {
			$this->db->query("UPDATE " . DB_PREFIX . "city SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "' WHERE id = '" . (int)$city_id . "'");
			
			$this->cache->delete('city');
		}
		
		public function getCities($data = array()) {
			
				if ($data) {
					$sql = "SELECT * FROM " . DB_PREFIX . "city";
					
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

				$city_data = $this->cache->get('city');
				
				if (!$city_data) {
					$city_data = array();
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city ORDER BY name ASC");
					
					foreach ($query->rows as $result) {
						$city_data[$result['id']] = array(
							'id'           => $result['id'],
							'name'         => $result['name'],
							'code'         => $result['code'],
						);
					}
					
					$this->cache->set('city', $city_data);
				}
				
				return $city_data;
		}
		
		public function deleteCity($city_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE id = '" . (int)$city_id . "'");
			
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
