<?phpdefined( '_JEXEC' ) or die( 'Restricted access' );jimport('joomla.application.component.controller');class MdagreementControllerAgreementlist extends JController{function publish(){$option = JRequest::getCmd('option');$cid = JRequest::getVar('cid', array());	$row =&JTable::getInstance('mdagreement', 'Table');$user =& JFactory::getUser();$publish = 1;if($this->getTask()== 'unpublish'){	$publish = 0;}foreach ($cid as $id){	$id = (int) $id;}$row->load($id);$row->published = $publish;$date = date('Y-m-d H:i:s');$user =& JFactory::getUser();if($user->id){$row->modified_by = $user->name;}$row->modified_date =$date;$row->store();$this->setRedirect('index.php?option=com_mdagreement');}function remove(){JRequest::checkToken() or jexit( 'Invalid Token' );$option = JRequest::getCmd('option');$cid = JRequest::getVar('cid', array(0));$row =& JTable::getInstance('mdagreement', 'Table');foreach ($cid as $id){$id = (int) $id;if (!$row->delete($id)){JError::raiseError(500, $row->getError() );}}$s = '';if (count($cid) > 1){$s = 's';}$this->setRedirect('index.php?option=' . $option, 'Agreement' . $s . ' deleted.');}function __construct($config = array()){parent::__construct($config);$this->registerTask('unpublish', 'publish');}function display(){$view = JRequest::getVar('view');if (!$view) {JRequest::setVar('view', 'all');}	parent::display();}}