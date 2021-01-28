<?php

namespace frontend\services\googlePlacesApi;

class PlaceItemFilter
{
	 protected $titleSearch;
	 protected $address;
	 protected $name;
	 protected $state;
	 protected $place_id;

	 const LEVEL_SEARCH_1_TITLE                  = true;
	 const LEVEL_SEARCH_2_TITLE_PARTS_AND_SUBURB = true;
	 const LEVEL_SEARCH_3_TITLE_PARTS            = true;

	 protected $partsTitle = [];
	 protected $partsTitle_Suburb = '';

	 public function __construct($title, $state, $name, $address, $place_id)
	 {
		  $this->titleSearch = $title;
		  $this->name = $name;
		  $this->state = ' ' . strtoupper($state) . ' ';
		  $this->address = $address;
		  $this->place_id = $place_id;
	 }


	 public function searchPlaceID()
	 {
		  if ($this->checkState()) {

				/* Search level #1 */
				if ($this->searchSimilarTitle()) {
					 return $this->place_id;
				}

				$this->clearTitle();

				/* Search level #2 */
				if ($this->searchTitlePartsAndSuburb()) {
					 return $this->place_id;
				}

				/* Search level #3 */
				if(self::LEVEL_SEARCH_3_TITLE_PARTS && $this->searchTitleParts()){
					 return $this->place_id;
				}

		  }
		  return false;
	 }

	 protected function checkState()
	 {
		  return strpos($this->address, $this->state);
	 }

	 protected function searchSimilarTitle()
	 {
		  if (self::LEVEL_SEARCH_1_TITLE) {
				similar_text($this->titleSearch, $this->name, $percent);
				if ($percent > 70) {
					 return true;
				}
		  }
		  return false;
	 }

	 protected function clearTitle()
	 {
		  if (self::LEVEL_SEARCH_2_TITLE_PARTS_AND_SUBURB || self::LEVEL_SEARCH_3_TITLE_PARTS) {
				$string = '';
				if (strpos($this->titleSearch, '(')) {
					 $string = $this->cutSuburbFromString();
				}

				$this->parseString($string);
		  }
	 }

	 /**
	  * @return string
	  */
	 protected function cutSuburbFromString()
	 {
		  $start = strpos($this->titleSearch, '(');
		  $end = strpos($this->titleSearch, ')');
		  $cut = substr($this->titleSearch, $start, $end - ($start - 1));
		  $this->partsTitle_Suburb = trim($cut, '(,)');
		  return str_replace($cut, '', $this->titleSearch);
	 }

	 protected function parseString($string = null)
	 {
		  $string = $string ? $string : $this->titleSearch;
		  $string = $this->filteredString($string);
		  $this->partsTitle = explode(' ', $string);
	 }

	 protected function filteredString($string)
	 {
		  return trim(str_replace([' & ', ' by ', ' and ', '  ', '   ',], ' ', $string));
	 }

	 protected function searchTitleParts()
	 {
		  foreach ($this->partsTitle as $string) {
		  	 if (stripos($this->name, $string) !== false) {
					 continue;
				}else {
					 return false;
				}
		  }
		  return true;
	 }

	 protected function searchTitlePartsAndSuburb()
	 {
		  if (!$this->partsTitle_Suburb && !self::LEVEL_SEARCH_2_TITLE_PARTS_AND_SUBURB) {
				return false;
		  }

		  if (!stripos($this->address, $this->partsTitle_Suburb)) {
				return false;
		  }

		  return $this->searchTitleParts();
	 }


}