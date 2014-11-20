<?php

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['V\\Scheduler4\\Task\\SampleTask'] = array(
		'extension' => $_EXTKEY,
		'title' => 'Scheduler4 test - example for new field',
		'description' => 'How to add new field to scheduler task.',
		'additionalFields' => 'V\\Scheduler4\\Task\\SampleTaskAdditionalFieldProvider'
);