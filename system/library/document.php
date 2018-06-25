<?php
class Document {
	private $title;
	private $description;
	private $keywords;
	private $links = array();
	private $styles = array();
	private $scripts = array();
	private $og_image;
	private $robots;
	private $canonical;
	
	/* META ROBOTS */
	public function setRobots($robots) {
		$this->robots = $robots;
	}
	
	public function getRobots() {
		return $this->robots;
	}
	/* META ROBOTS  */
	
	/* META CANNONICAL */
	public function setCanonical($canonical) {
		$this->canonical = $canonical;
	}
	
	public function getCanonical() {
		return $this->canonical;
	}
	/* META CANNONICAL */
	
	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}
	
	// OCFilter canonical fix start
	public function deleteLink($rel) {
		foreach ($this->links as $href => $link) {
			if ($link['rel'] == $rel) {
				unset($this->links[$href]);
			}
		}
	}
	// OCFilter canonical fix end

	public function getLinks() {
		return $this->links;
	}

	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}

	public function setOgImage($image) {
		$this->og_image = $image;
	}

	public function getOgImage() {
		return $this->og_image;
	}
}
