<?php
namespace GDO\Poll\Method;

use GDO\Core\Application;
use GDO\Core\GDT;
use GDO\Date\Time;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_Validator;
use GDO\Form\MethodForm;
use GDO\Poll\GDO_Poll;
use GDO\Poll\GDO_PollChoice;
use GDO\Poll\MethodPoll;
use GDO\Poll\Module_Poll;
use GDO\UI\GDT_AddButton;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Repeat;
use GDO\UI\GDT_Title;
use GDO\User\GDO_User;

/**
 * Let users create polls.
 *
 * @author gizmore
 *
 */
final class Create extends MethodForm
{

	use MethodPoll;

	public function isUserRequired(): bool
	{
		return true;
	}

	public function isGuestAllowed(): bool
	{
		return false;
	}

	public function getMethodTitle(): string
	{
		return t('create_poll');
	}

	public function createForm(GDT_Form $form): void
	{
		$poll = GDO_Poll::table();
		$user = GDO_User::current();
		$modp = Module_Poll::instance();

		$form->text('info_create_poll', [
			$modp->cfgLevelPerPoll(),
			$user->getLevelAvailable(),
		]);

		$form->addFields(
			$poll->gdoColumn('poll_language'),
			$poll->gdoColumn('poll_question'),
			$poll->gdoColumn('poll_description'),
			$poll->gdoColumn('poll_expires')->minTimestamp(Application::$TIME + Time::ONE_WEEK),
			$poll->gdoColumn('poll_max_answers'),
		);

		if ($modp->cfgGuestVotes())
		{
			$form->addFields(
				$poll->gdoColumn('poll_guests'),
			);
		}

		$form->addFields(
			$poll->gdoColumn('poll_level'),
		);

		$form->addFields(
			GDT_Validator::make('validate_level')->validatorFor($form, 'poll_question', [$this, 'validateLevel']),
			GDT_Repeat::makeAs('options', GDT_Title::make()->min(1)->label('answer'))->minRepeat(2),
			GDT_AntiCSRF::make(),
		);

		$form->actions()->addFields(
			GDT_Submit::make(),
			GDT_AddButton::make('add_more_answers')->onclick([$this, 'addQuestions'])->label('add_more_answers'),
		);
	}

	public function formValidated(GDT_Form $form)
	{
		# Poll
		$poll = GDO_Poll::blank($form->getFormVars())->insert();
		$pollid = $poll->getID();

		# Answers
		$choices = $form->getFormValue('options');
		foreach ($choices as $choice)
		{
			GDO_PollChoice::blank([
				'choice_poll' => $pollid,
				'choice_text' => $choice,
			])->insert();
		}

		# Level cost
		$user = GDO_User::current();
		$cost = Module_Poll::instance()->cfgLevelPerPoll();
		$user->increaseSetting('User', 'level_spent', $cost);

		return $this->message('msg_poll_added', [
			$pollid,
			count($choices),
			GDT_Link::anchor($poll->hrefView(), $poll->renderTitle()),
		]);
	}

	public function validateLevel(GDT_Form $form, GDT $field, $value)
	{
		$user = GDO_User::current();
		$has = $user->getLevelAvailable();
		$need = Module_Poll::instance()->cfgLevelPerPoll();
		if ($has < $need)
		{
			return $field->error('err_create_poll_level', [
				$need, $has,
			]);
		}
		return true;
	}

	public function addQuestions()
	{
		return $this->renderPage();
	}

}
