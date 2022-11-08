<?php
namespace GDO\Poll\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Poll\GDT_Poll;
use GDO\Poll\MethodPoll;
use GDO\Poll\GDO_Poll;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\User\GDO_User;
use GDO\UI\GDT_HTML;
use GDO\Poll\GDT_PollOutcome;
use GDO\Poll\GDT_PollAnswer;

final class Answer extends MethodForm
{
	
	use MethodPoll;
	
	public function getMethodTitle(): string
	{
		return $this->getPoll()->renderTitle();
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
	
	public function getPoll(): GDO_Poll
	{
		return $this->gdoParameterValue('poll');
	}
	
	public function createForm(GDT_Form $form): void
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
			GDT_HTML::make('poll_descr')->var($poll->renderDescription()),
		);
		foreach ($poll->getChoices() as $choice)
		{
			$form->addField(
				GDT_PollOutcome::make("choice_{$choice->getID()}")->gdo($choice)
			);
		}
		
		$form->addFields(
			GDT_PollAnswer::make('answer')->gdo($poll),
		);
		
		$form->addFields(
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(
			GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$poll = $this->getPoll();
		$user = GDO_User::current();
		$isUpdate = $poll->hasAnswered($user);
		
	}
	
}
