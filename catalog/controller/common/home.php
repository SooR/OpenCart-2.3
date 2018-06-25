<?php
class ControllerCommonHome extends Controller {
	public function index()
	{
		$this->load->model('common/city');
		
		$city_code = $this->session->data['city'];
		
		$results = $this->model_common_city->getCityDescription($city_code);

		$this->document->setTitle($results['title']);
		$this->document->setDescription($results['meta_description']);
		
		$data['meta_h1'] = $results['title'];
		$data['description'] = html_entity_decode($results['description'], ENT_QUOTES, 'UTF-8');
		
		if (!$data['description'] || !$results['robots']){
			$this->document->setRobots('noindex, nofollow');
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
