<?php
namespace GDO\Poll\lang;
return [
	'module_poll' => 'Umfragen',
	
	'link_polls' => '%s Umfragen',
	
	# Config
	'cfg_level_per_poll' => 'Level cost per Poll',	'cfg_guest_votes' => 'Allow guest votes?',
	
	# GDO_Poll
	'gdo_poll' => 'Umfrage',
	'question' => 'Frage',
	'multiple_choice' => 'Mehrfachantworten',
	'poll_guests' => 'Gastantworten',
	'poll_level' => 'Nutzerlevel zum Abstimmen',
	'poll_usercount' => 'Teilnehmer',
	'poll_you_answered' => 'Sie haben hierfür abgestimmt.',
	'poll_you_questioned' => 'Sie haben hierfür nicht abgestimmt.',
	
	# GDT_Poll
	'err_poll_expired' => 'Diese Umfrage ist beendet.',
	'err_poll_only_expired' => 'Diese Umfrage ist noch nicht beendet.',
	
	# GDO_Choice
	'answer' => 'Antwort',

	# Overview
	
	# Create
	'create_poll' => 'Umfrage Erstellen',
	'choose_multiple_choice' => 'Einstellung wählen',
	'info_create_poll' => 'Es kostet %s Punkte eine Umfrage zu erstellen. Du hast %s Punkte.',
	'add_more_answers' => 'Mehr Antworten',
	'err_create_poll_level' => 'Es kostet %s Punkte eine Umfrage zu erstellen. Du hast nur %s Punkte.',
	'msg_poll_added' => 'Umfrage #%s wurde mit %s möglichen Antworten erstellt: %s',
	
	# Answer
	'info_poll_answer' => 'Nehmen Sie Teil an dieser Umfrage. %s',
	'info_mpoll_answer' => 'Nehmen Sie Teil an dieser Multiple-Choice-Umfrage. %s',
	'please_vote' => 'Bitte abstimmen',
	'msg_poll_voted' => 'Sie haben an Umfrage %s `%s` teilgenommen.',
	
	# CronjobOutcome
	'mails_poll_finished' => '%s: %s answered',
	'mailb_poll_finished' => '
Hello %s,

A poll on %s has been closed.

%s

=============================

%s

=============================

Kind Regards,
The %2$s Team',	
];