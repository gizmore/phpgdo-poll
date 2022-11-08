<?php
namespace GDO\Poll\Method;

use GDO\Cronjob\MethodCronjob;
use GDO\Poll\GDO_Poll;
use GDO\Date\Time;
use GDO\User\GDO_User;
use GDO\Mail\Mail;

/**
 * Send Email to poll creator when finished.
 * 
 * @author gizmore
 */
final class CronjobOutcome extends MethodCronjob
{
	public function runAt(): string
	{
		return $this->runDaily(0);
	}
	
	public function run()
	{
		$today = Time::getDateWithoutTime();
		$polls = GDO_Poll::table()->select()
			->where("poll_expires='$today'")
			->exec();
		while ($poll = $polls->fetchObject())
		{
			$this->runFor($poll);
		}
	}
	
	public function runFor(GDO_Poll $poll): void
	{
		$this->sendMailFor($poll, $poll->getCreator());
	}
	
	public function sendMailFor(GDO_Poll $poll, GDO_User $user): void
	{
		$mail = Mail::botMail();
		$mail->setSubject(t('mails_poll_finished', [sitename(), $poll->renderTitle()]));
		$args = [
			$user->renderUserName(),
			sitename(),
			$poll->renderTitle(),
			$this->renderMailOutcome($poll, $user),
		];
		$mail->setBody(t('mailb_poll_finished', $args));
		$mail->sendToUser($user);
	}
	
	private function renderMailOutcome(GDO_Poll $poll, GDO_User $user): string
	{
		$outcome = '';
		foreach ($poll->getChoices('choice_amount') as $choice)
		{
			$outcome .= sprintf("%05d(%s): %s\n",
				$choice->getAmount(),
				$choice->renderPercent(),
				$choice->renderTitle());
		}
		return $outcome;
	}

}
