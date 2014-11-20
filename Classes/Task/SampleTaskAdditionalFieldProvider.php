<?php

namespace V\Scheduler4\Task;


use TYPO3\CMS\Core\Utility\GeneralUtility;

class SampleTaskAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {

	/**
	 * This method is used to define new fields for adding or editing a task
	 * In this case, it adds an email field
	 *
	 * @param array $taskInfo Reference to the array containing the info used in the add/edit form
	 * @param object $task When editing, reference to the current task object. Null when adding.
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
	 * @return array    Array containing all the information pertaining to the additional fields
	 */
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
		switch ($parentObject->CMD) {
			case 'add':
				$taskInfo['frequency'] = '*/15 * * * *'; // set default frequency for new tasks
				break;
			case 'edit':
				$taskInfo['scheduler4']['email'] = $task->email;
				break;
			default:
				$taskInfo['scheduler4']['email'] = '';

		}

		$fieldCode = '<input type="text" name="tx_scheduler[scheduler4][email]" value="' . htmlspecialchars($taskInfo['scheduler4']['email']) . '" size="30" />';
		$additionalFields = array();
		$additionalFields['tx_scheduler4_email'] = array(
				'code' => $fieldCode,
				'label' => 'Email',
		);
		return $additionalFields;
	}

	/**
	 * This method checks any additional data that is relevant to the specific task
	 * If the task class is not relevant, the method is expected to return TRUE
	 *
	 * @param array $submittedData Reference to the array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject Reference to the calling object (Scheduler's BE module)
	 * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
		$emailSubmitted = trim($submittedData['scheduler4']['email']);
		if (strlen($emailSubmitted) && !GeneralUtility::validEmail($emailSubmitted)) {
			$parentObject->addMessage('Not a valid email', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			$result = FALSE;
		} else {
			$result = TRUE;
		}
		return $result;
	}

	/**
	 * This method is used to save any additional input into the current task object
	 * if the task class matches
	 *
	 * @param array $submittedData Array containing the data submitted by the user
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the current task object
	 * @return void
	 */
	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		$task->email = $submittedData['scheduler4']['email'];
	}

}
