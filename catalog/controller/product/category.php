<?php
class ControllerProductCategory extends Controller {
	public function index() {
		
		$this->document->addScript('catalog/view/javascript/jquery/jquery.autopager.js');
		$this->document->addScript('catalog/view/javascript/bal_loader.js');
		
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}
		
		// OCFilter start
		if (isset($this->request->get['filter_ocfilter'])) {
			$filter_ocfilter = $this->request->get['filter_ocfilter'];
		} else {
			$filter_ocfilter = '';
		}
		// OCFilter end

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);
			
			$categoryPaths = $this->model_catalog_category->getCategoryPath($category_id);
			
			if($categoryPaths) {
				
				foreach ($categoryPaths as $categoryPaths) {
					
					$category_info = $this->model_catalog_category->getCategory($categoryPaths['path_id']);
					
					if ($category_info) {
						$data['breadcrumbs'][] = array(
							'text' => $category_info['name'],
							'href' => $this->url->link('product/category', 'path=' . $categoryPaths['path_id'])
						);
					}
				}
			}
			
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			
			// Cities
			$city_code = $this->session->data['city'];
			
			$city_id = $this->model_common_city->getCityByCode($city_code);
			
			if($city_id) {
				$city_description = $this->model_common_city->getCityCategory($city_id['id'], $category_id);
			}
			// Cities
			
			if (isset($city_description['title'])) {
				$this->document->setTitle($city_description['title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}
			
			$city_code = $this->session->data['city'];
			$results = $this->model_common_city->getCityDescription($city_code);
			
			if (isset($city_description['description']) && isset($city_description['robots'])) {
				if (!$city_description['description'] || !$city_description['robots']) {
					$this->document->setRobots('noindex, nofollow');
				}
			} else if(isset($results['robots'])){
				if (!$results['robots']) {
					$this->document->setRobots('noindex, nofollow');
				}
			}
			
			
			if(isset($this->request->get['filter_ocfilter'])) {
				
				$ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo');
				
				if($ocfilter_page_info){
					$this->document->setCanonical((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($_SERVER['REQUEST_URI'],1));
				}
				else{
					$this->document->setRobots('noindex, nofollow');
					
					if (isset($city_description['canonical'])) {
						if ($city_description['canonical']) {
							$this->document->setCanonical($city_description['canonical']);
						}
					}
					
				}
				
			} else if (isset($city_description['canonical'])) {
				
				if ($city_description['canonical']) {
					$this->document->setCanonical($city_description['canonical']);
				}
			} else{
				$this->document->setCanonical($this->url->link('product/category', 'path=' . $category_info['category_id'], true));
			}
			
			if (isset($city_description['meta_description'])) {
				$this->document->setDescription($city_description['meta_description']);
			}
			
			if (isset($city_description['meta_keyword'])) {
				$this->document->setKeywords($city_description['meta_keyword']);
			}

			if (isset($city_description['meta_h1'])) {
				$data['heading_title'] = $city_description['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			
			// Ajax page load
			$data['text_show_next'] = $this->language->get('text_show_next');
			$data['text_show_allp'] = $this->language->get('text_show_allp');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_no_more_show'] = $this->language->get('text_no_more_show');
			$data['text_d1_items'] = $this->language->get('text_d1_items');
			$data['text_d2_items'] = $this->language->get('text_d2_items');
			$data['text_d3_items'] = $this->language->get('text_d3_items');
			
			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
				$this->document->setOgImage($data['thumb']);
			} else {
				$data['thumb'] = '';
			}
			if (isset($city_description['description']) && $page == 1) {
				$data['description'] = html_entity_decode($city_description['description'], ENT_QUOTES, 'UTF-8');
			}else{
				$data['description'] = "";
			}
			
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			
			// OCFilter start
			$filter_data['filter_ocfilter'] = $filter_ocfilter;
			// OCFilter end

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				
					$product_stickers = array();
				
					$this->load->model('design/stikers');
					
					if (isset($result['product_stickers']) && $result['product_stickers']) {
						$stickers = unserialize($result['product_stickers']);
					} else {
						$stickers = array();
					}
					
					if ($stickers) {
						foreach ($stickers as $product_sticker_id) {
							$sticker_info = $this->model_design_stikers->getProductSticker($product_sticker_id);
							
							if ($sticker_info) {
								$product_stickers[] = array(
									'text' => $sticker_info['text'],
									'color' => $sticker_info['color'],
									'background' => $sticker_info['background']
								);
							}
						}
						
						$sticker_sort_order = array();
						
						foreach ($stickers as $key => $product_sticker_id) {
							$sticker_info = $this->model_design_stikers->getProductSticker($product_sticker_id);
							
							if ($sticker_info) {
								$sticker_sort_order[$key] = $sticker_info['sort_order'];
							}
						}
						
						array_multisort($sticker_sort_order, SORT_ASC, $product_stickers);
					}
					

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => ($result['minimum'] > 0) ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
					'product_stickers' => $product_stickers,
				);
			}

			$url = '';
			
			// OCFilter start
			if (isset($this->request->get['filter_ocfilter'])) {
				$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
			}
			// OCFilter end

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';
			
			// OCFilter start
			if (isset($this->request->get['filter_ocfilter'])) {
				$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
			}
			// OCFilter end

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';
			
			// OCFilter start
			if (isset($this->request->get['filter_ocfilter'])) {
				$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
			}
			// OCFilter end

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    //$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			
			// OCFilter Start
			if (isset($this->request->get['filter_ocfilter'])) {
				if (!$product_total) {
					$this->response->redirect($this->url->link('product/category', 'path=' . $this->request->get['path']));
				}
				
				$data['description'] = '';
			}
			
			$ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo');
			
			if ($ocfilter_page_info) {
				$this->document->setTitle($ocfilter_page_info['meta_title']);
				
				if ($ocfilter_page_info['meta_description']) {
					$this->document->setDescription($ocfilter_page_info['meta_description']);
				}
				
				if ($ocfilter_page_info['meta_keyword']) {
					$this->document->setKeywords($ocfilter_page_info['meta_keyword']);
				}
				
				$data['heading_title'] = $ocfilter_page_info['title'];
				
				if ($ocfilter_page_info['description'] && !isset($this->request->get['page']) && !isset($this->request->get['sort']) && !isset($this->request->get['order']) && !isset($this->request->get['search']) && !isset($this->request->get['limit'])) {
					$data['description'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
				}
				
				$data['breadcrumbs'][] = array(
					'text' => $ocfilter_page_info['title'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
				);
			} else {
				$meta_title = $this->document->getTitle();
				$meta_description = $this->document->getDescription();
				$meta_keyword = $this->document->getKeywords();
				
				$filter_title = $this->load->controller('extension/module/ocfilter/getSelectedsFilterTitle');
				
				if ($filter_title) {
					if (false !== strpos($meta_title, '{filter}')) {
						$meta_title = trim(str_replace('{filter}', $filter_title, $meta_title));
					} else {
						$meta_title .= ' ' . $filter_title;
					}
					
					$this->document->setTitle($meta_title);
					
					if ($meta_description) {
						if (false !== strpos($meta_description, '{filter}')) {
							$meta_description = trim(str_replace('{filter}', $filter_title, $meta_description));
						} else {
							$meta_description .= ' ' . $filter_title;
						}
						
						$this->document->setDescription($meta_description);
					}
					
					if ($meta_keyword) {
						if (false !== strpos($meta_keyword, '{filter}')) {
							$meta_keyword = trim(str_replace('{filter}', $filter_title, $meta_keyword));
						} else {
							$meta_keyword .= ' ' . $filter_title;
						}
						
						$this->document->setKeywords($meta_keyword);
					}
					
					$heading_title = $data['heading_title'];
					
					if (false !== strpos($heading_title, '{filter}')) {
						$heading_title = trim(str_replace('{filter}', $filter_title, $heading_title));
					} else {
						$heading_title .= ' ' . $filter_title;
					}
					
					$data['heading_title'] = $heading_title;
					
					$data['description'] = '';
					
					$data['breadcrumbs'][] = array(
						'text' => (utf8_strlen($heading_title) > 30 ? utf8_substr($heading_title, 0, 30) . '..' : $heading_title),
						'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
					);
				} else {
					$this->document->setTitle(trim(str_replace('{filter}', '', $meta_title)));
					$this->document->setDescription(trim(str_replace('{filter}', '', $meta_description)));
					$this->document->setKeywords(trim(str_replace('{filter}', '', $meta_keyword)));
					
					$data['heading_title'] = trim(str_replace('{filter}', '', $data['heading_title']));
				}
			}
			// OCFilter End

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
