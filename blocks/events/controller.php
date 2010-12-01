<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('file_attributes'); 

class EventsBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btEvents';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Display a gallery of events.");
	}
	
	public function getBlockTypeName() {
		return t("Events");
	}
	
	public function getJavaScriptStrings() {
		return array(
			'choose-event' => t('Please choose an Event.')
		);
	}
	
	function view() {
		//$this->loadEventsInformation();
		$this->loadEventsInformationWithPublishDates();
	}

	function add() {
		$this->loadEventsInformation();
	}
	
	function edit() {
		$this->loadEventsInformation();
	}
	
	protected function loadEventsInformationWithPublishDates() {
		$this->loadEventsWithPublishDates();
		
		$this->set('bID', $this->bID);
		$this->set('title', $this->title);			

		$this->prepareEventArray();
	}
	
	protected function loadEventsInformation() {
		$this->loadEvents();
		
		$this->set('bID', $this->bID);
		$this->set('title', $this->title);			

		$this->prepareEventArray();
	}
	
	function prepareEventArray(){
		$events_json 		= new stdClass();
		$event_info = $this->events;
		$jse = Loader::helper('json');
		$this->set('events_json', $jse->encode($events_json));	
		$this->set('events', $event_info);
	}
	
	function loadEventsWithPublishDates() {
		$db = Loader::db();
		if(intval($this->bID)==0) $this->events=array();
		if(intval($this->bID)==0) return array();
		$sql = "SELECT * FROM btEventsEvent WHERE btEventsID=".intval($this->bID).' AND publish_from <= CURDATE() AND publish_to >= CURDATE() ORDER BY display_order';
		$this->events=$db->getAll($sql); 
	}
	
	function loadEvents() {
		$db = Loader::db();
		if(intval($this->bID)==0) $this->events=array();
		if(intval($this->bID)==0) return array();
		$sql = "SELECT * FROM btEventsEvent WHERE btEventsID=".intval($this->bID).' ORDER BY display_order';
		$this->events=$db->getAll($sql); 
	}
	
	
	function delete() {
		$db = Loader::db();
		$db->query("DELETE FROM btEventsEvent WHERE btEventsID=".intval($this->bID));		
		parent::delete();
	}
	
	function save($data) {
		$db = Loader::db();
		//$db->query("DELETE FROM btEventsEvent WHERE btEventsID=".intval($this->bID));
		Loader::model('collection_types');
		$args['title'] = $data['title'];
		
		$events_page = Page::getByPath('/events');
		
		$touchedEvents = array();
		//loop through and add the events
		//$id=0;
		foreach($data['event_name'] as $id => $name)
		{
			if ($name === 'tempName') continue;
			
			if ($data['eventsEventId'][$id] > 0) //old event
			{
				
				//if(intval($imgFID)==0 || $data['fileNames'][$pos]=='tempFilename') continue;
		
				//save individual image shown attributes 
				
				$vals = array(intval($id), trim($name),
				      $this->convertDate(trim($data['event_date'][$id])),
				       $this->convertDate(trim($data['publish_from'][$id])),
				       $this->convertDate(trim($data['publish_to'][$id])),
				      trim($data['short_description'][$id]),
				      intval($data['fID'][$id]),
				      intval($data['eventsEventId'][$id]));
				$db->query("UPDATE btEventsEvent SET 
				 display_order = ? , event_name = ? ,event_date = ?,publish_from = ? ,publish_to = ?,short_description = ?,
				 fID = ?
				 WHERE eventsEventId = ?",$vals);
				
				//rename page if it has changed
				$page_id = $db->getOne("SELECT page_id FROM btEventsEvent WHERE eventsEventId = ?",$data['eventsEventId'][$id]);
				$page = Page::getById($page_id);
				//does page exist?
				//var_dump($page);
				//die();
				if ($page->cID != null)
				{
					//page exists, so rename it if needed
					if ($page->getCollectionName() != trim($name))
					{
						$page->update(array('cName' => trim($name),'cDatePublic' => date('Y-m-d h:m:s')));
					}
				}
				else //create it if it doesn't
				{
					$pageData = array('cName' => trim($name), 'cDescription' => 'Event Page for '.trim($name));
					$ct = CollectionType::getByHandle('full');
					$page = $events_page->add($ct,$pageData);
					
					//add a content block to it just containing header and the short description
					$bt = BlockType::getByHandle('content');
					$page_data = array('content' => '<h2>Events - '.trim($name).'</h2><p>'.trim($data['short_description'][$id]).'</p>');
					$page->addBlock($bt,'Main',$page_data);
					
					$db->query("UPDATE btEventsEvent SET page_id = ? WHERE eventsEventID = ?", array($page->cID, $data['eventsEventId'][$id]) );	
				}
				$touchedEvents[] = $data['eventsEventId'][$id];
			}
			else //new event
			{
				//if(intval($imgFID)==0 || $data['fileNames'][$pos]=='tempFilename') continue;
		
				//save individual image shown attributes 
			
				$vals = array(intval($this->bID),intval($id), trim($name),
				      $this->convertDate(trim($data['event_date'][$id])),
				       $this->convertDate(trim($data['publish_from'][$id])),
				       $this->convertDate(trim($data['publish_to'][$id])),
				      trim($data['short_description'][$id]),
				      intval($data['fID'][$id]));
				$db->query("INSERT INTO btEventsEvent 
				(btEventsID,display_order,event_name,event_date,publish_from,publish_to,short_description,fID) 
				values (?,?,?,?,?,?,?,?)",$vals);
				//need to get the insert ID here
				$event_id = $db->getOne("SELECT LAST_INSERT_ID() AS id");
				
				//create page
				$pageData = array('cName' => trim($name), 'cDescription' => 'Event Page for '.trim($name));
				$ct = CollectionType::getByHandle('full');
				$page = $events_page->add($ct,$pageData);
				
				//add a content block to it just containing header and the short description
				$bt = BlockType::getByHandle('content');
				$data = array('content' => '<h2>Events - '.trim($name).'</h2><p>'.trim($data['short_description']['id']).'</p>');
				$page->addBlock($bt,'Main',$data);
				
				
				$db->query("UPDATE btEventsEvent SET page_id = ? WHERE eventsEventID = ?", array($page->cID, $event_id));
				$touchedEvents[] = $event_id;
			}	
			//$id++;
		}
		if (count($touchedEvents) > 0)
		{
			$db->query("DELETE FROM btEventsEvent WHERE btEventsID=".intval($this->bID)." AND eventsEventId NOT IN (".join(',',$touchedEvents).')');
		}	
		parent::save($args);
	}
	
	private function convertDate($str)
	{
		return $str;
		//$components = explode('/',$str);
		//return $components[2].'-'.$components[0].'-'.$components[1];
	}
	
}

?>
