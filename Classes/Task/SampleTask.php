<?php

namespace V\Scheduler4\Task;

class SampleTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {


	/**
	 * Email
	 *
	 * @var string $email
	 */
	public $email;

	public function execute() {
		return TRUE;
	}

	public function getAdditionalInformation() {
		return 'Email: ' . $this->email;
	}

}