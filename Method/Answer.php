<?php
namespace GDO\Poll\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Hook;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Poll\GDO_Poll;
use GDO\Poll\GDO_PollAnswer;
use GDO\Poll\GDO_PollChoice;
use GDO\Poll\GDT_Poll;
use GDO\Poll\GDT_PollAnswer;
use GDO\Poll\GDT_PollResults;
use GDO\Poll\MethodPoll;
use GDO\User\GDO_User;
use GDO\Util\Arrays;

/**
 * Vote on polls.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class Answer extends MethodForm
{

	use MethodPoll;

	public function getMethodTitle(): string
	{
		return $this->getPoll()->renderTitle();
	}

	public function getPoll(): GDO_Poll
	{
		return $this->gdoParameterValue('poll');
	}

	public function gdoParameters(): array
	{
		return [
			GDT_Poll::make('poll')->notNull()->open(),
		];
	}

	public function isShownInSitemap(): bool
	{
		return false;
	}

	protected function createForm(GDT_Form $form): void
	{
		$poll = $this->getPoll();
		$user = GDO_User::current();
		$key = 'info_poll_answer';
		if ($poll->isMultipleChoice())
		{
			$key = 'info_mpoll_answer';
		}
		$form->text($key, [$poll->getAnsweredText($user)]);
		$form->addFields(
			GDT_PollResults::make('result')->gdo($poll),
		);

		$form->addFields(
			GDT_PollAnswer::make('answer')->gdo($poll),
		);

		$form->addFields(
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(
			GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$poll = $this->getPoll();
		$user = GDO_User::current();
		$isUpdate = $poll->hasAnswered($user);

		/** @var $answers GDO_PollChoice[] * */
		$answers = Arrays::arrayed($form->getFormValue('answer'));

		GDO_PollAnswer::clearPollFor($user, $poll);

		foreach ($answers as $choice)
		{
			GDO_PollAnswer::blank([
				'answer_user' => $user->getID(),
				'answer_choice' => $choice->getID(),
			])->insert();
		}

		$poll->recalculate();

		if ($isUpdate)
		{
			GDT_Hook::callWithIPC('PollVoteUpdated', $user, $poll, $answers);
		}
		else
		{
			GDT_Hook::callWithIPC('PollVoteCreated', $user, $poll, $answers);
		}

		return $this->redirectMessage('msg_poll_voted', [
			$poll->getID(),
			$poll->renderTitle(),
		], $poll->hrefView());
	}

}
