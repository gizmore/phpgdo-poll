<?php
namespace GDO\Poll\lang;
return [
	'module_poll' => 'Polls',
	
	'link_polls' => '%s Polls',
	
	# Config
	'cfg_level_per_poll' => 'Level cost per Poll',
	'cfg_guest_votes' => 'Allow guest votes?',
	
	# GDO_Poll
	'gdo_poll' => 'Poll',
	'question' => 'Question',
	'multiple_choice' => 'Multiple Choice',
	'poll_guests' => 'Guest-Answers',
	'poll_level' => 'Userlevel to vote',
	'poll_you_answered' => 'You have voted for this.',
	'poll_you_questioned' => 'You have not voted for this.',
	
	# GDT_Poll
	'err_poll_expired' => 'This poll is alredy expired.',
	'err_poll_only_expired' => 'This poll is not expired.',
	
	# GDO_Choice
	'answer' => 'Answer',
	
	# Overview

	# Create
	'create_poll' => 'Create Poll',
	'choose_multiple_choice' => 'Choose setting',
	'info_create_poll' => 'It cost %s points to create a poll and you got %s.',
	'add_more_answers' => 'Add Answers',
	'err_create_poll_level' => 'It cost %s points to create a poll but you only got %s.',
	'msg_poll_added' => 'Poll #%s has been created with %s answers: %s',

	# Answer
	'info_poll_answer' => 'Participate in this poll. %s',
	'info_mpoll_answer' => 'Participate in this multiple choice poll. %s',
	'please_vote' => 'Please vote',
	'msg_poll_voted' => 'You have voted for Poll#%s - %s',
	
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
