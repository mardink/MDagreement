<?phpdefined( '_JEXEC' ) or die( 'Restricted access' );jimport('joomla.application.component.controller');class MdagreementController extends JController{	function accept(){JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'tables');$row =&JTable::getInstance('mdagreement', 'Table');$user =& JFactory::getUser();	$params =& JFactory::getApplication()->getParams();	$showaccept = $params->get('accept_text');	$linka = $params->get('accept_link');if($user->id){$row->user_id = $user->id;}if($user->id){$row->full_name = $user->name;}$row->accept_date = date('Y-m-d H:i:s');$row->published = '1';if(!$row->store()){	JError::raiseError(500, $row->getError());}if($showaccept==1){JRequest::setVar('view', 'single');JRequest::setVar('layout', 'accepted');$this->display();}else{	$this->setRedirect($linka);}}	function deny(){JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'tables');$row =&JTable::getInstance('mdagreement', 'Table');$user =& JFactory::getUser();	$params =& JFactory::getApplication()->getParams();	$showdenied = $params->get('denied_text');	$linkd = $params->get('denied_link');if($user->id){$row->user_id = $user->id;}if($user->id){$row->full_name = $user->name;}$row->accept_date = date('Y-m-d H:i:s');$row->published = '0';if(!$row->store()){	JError::raiseError(500, $row->getError());}if($showdenied==1){JRequest::setVar('view', 'single');JRequest::setVar('layout', 'denied');$this->display();}else{	$this->setRedirect($linkd);}}function login(){	$user = &JFactory::getUser();$userid = $user->id;$params =& JFactory::getApplication()->getParams();$linka = $params->get('accept_link');$db = &JFactory::getDBO();$select2 = "SELECT published FROM #__mdagreement where user_id=$userid;";$db->setQuery($select2);$status = $db->loadresult();if ($status==0||$status==1){$this->setRedirect("index.php?option=com_mdagreement&task=loginuser");	}else{$this->setRedirect("index.php?option=com_mdagreement");	}}function loginuser(){	$user = &JFactory::getUser();$userid = $user->id;$params =& JFactory::getApplication()->getParams();$linka = $params->get('accept_link');$db = &JFactory::getDBO();$select2 = "SELECT published FROM #__mdagreement where user_id=$userid;";$db->setQuery($select2);$status = $db->loadresult();if ($status==0){$this->setRedirect("index.php?option=com_mdagreement&task=deniedlink");	}if ($status==1){$this->setRedirect($linka);	}}function deniedlink(){	$params =& JFactory::getApplication()->getParams();	$showdenied = $params->get('denied_text');	$linkd = $params->get('denied_link');	$linka = $params->get('accept_link');if($showdenied==1){JRequest::setVar('view', 'single');JRequest::setVar('layout', 'denied');$this->display();}else{$this->setRedirect($linkd);}}function insideModal(){	$params =& JFactory::getApplication()->getParams();	$contentid = $params->get('agreement');	$db = &JFactory::getDBO();$select = "SELECT introtext FROM #__content where id=$contentid;";$db->setQuery($select);$content = $db->loadresult();$dbb = &JFactory::getDBO();$select1 = "SELECT title FROM #__content where id=$contentid;";$dbb->setQuery($select1);$title = $dbb->loadresult();	?><h1><?php echo $title;?></h1><ul><?php echo $content;?></ul><?php}	function display(){JHTML::_('behavior.modal', 'a.popup');	$view = JRequest::getVar('view');if (!$view) {JRequest::setVar('view', 'single');}parent::display();}}$controller = new MdagreementController();$controller->execute( $task );$controller->redirect();