<?php

	require 'config.php';
	
	dol_include_once('/contact/class/contact.class.php');
	dol_include_once('/perriax/class/perriax.class.php');
	
	$object = new Contact($db);
	$object->fetch(GETPOST('fk_contact'));
	
	$action = GETPOST('action');
        
	$simple = new TPerriax38000($db);
	$simple->fetchByContact($object->id);
	
	
	switch ($action) {
		case 'save':
			
			$simple->setValues($_POST);
			if($simple->id>0) $simple->update($user);
			else $simple->create($user);
			
			setEventMessage('Element simple sauvegardé');
			
			_card($object,$simple);
			break;
		default:
			_card($object,$simple);
			break;
	}
	
	
	
function _card(&$object,&$simple) {
	global $db,$conf,$langs;

	dol_include_once('/core/lib/contact.lib.php');
	
	llxHeader();
	$head = contact_prepare_head($object);
	dol_fiche_head($head, 'tab208000', '', 0, '');
        
        $types_list = array('Citron', 'Agrumes', 'Pamplemouse', 'Fines bulles', 'Pastèque', 'Orange');
                
	$formCore=new TFormCore('perriax_index.php', 'formSimple');
	echo $formCore->hidden('fk_contact', $object->id);
	echo $formCore->hidden('action', 'save');
	
	echo '<h2>Gestion de Perrier</h2>';
	
	echo $formCore->texte('Perriax','perrier',$simple->title,80,255).'<br />';
        
        echo $formCore->combo('Type','type',$types_list,[0]).'<br />';
        
        echo $formCore->bt('Du perrier !!!','add', $simple->title,80,255).'<br />';
	
	echo $formCore->btsubmit('Sauvegarder', 'bt_save');
	
	$formCore->end();
	
	dol_fiche_end();
	llxFooter();	  
		 	
}

