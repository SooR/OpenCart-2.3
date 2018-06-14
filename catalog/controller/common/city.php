<?php
	class ControllerCommonCity extends Controller
	{
		public function index(){
			$this->load->language('common/city');
			
			$data['text_city'] = $this->language->get('text_city');
			
			$data['action'] = $this->url->link('common/city/city', '', isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')));
			
			$data['city'] = $this->session->data['city'];
			
			$this->load->model('common/city');
			
			$data['cities'] = array();
			
			$results = $this->model_common_city->getCities();
			
			foreach ($results as $result) {
				if ($result['status']) {
					$data['cities'][] = array(
						'id' => $result['id'],
						'code' => $result['code'],
						'name' => $result['name'],
					);
				}
			}
			
			
			if (!isset($this->request->get['route'])) {
				$data['redirect'] = $this->url->link('common/home');
			} else {
				$url_data = $this->request->get;
				
				unset($url_data['_route_']);
				
				$route = $url_data['route'];
				
				unset($url_data['route']);
				
				$url = '';
				
				if ($url_data) {
					$url = '&' . urldecode(http_build_query($url_data, '', '&'));
				}
				
				$data['redirect'] = $this->url->link($route, $url, isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')));
			}
			
			
			return $this->load->view('common/city', $data);
			
		}
		
		public function city() {
			if (isset($this->request->post['code'])) {
				$this->session->data['city'] = $this->request->post['code'];
			}
			
			if (isset($this->request->post['redirect'])) {
				$this->response->redirect($this->request->post['redirect']);
			} else {
				$this->response->redirect($this->url->link('common/home'));
			}
		}
	}
