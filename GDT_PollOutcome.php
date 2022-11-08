<?php
namespace GDO\Poll;

use GDO\UI\GDT_Paragraph;
use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;
use GDO\UI\GDT_Icon;
use GDO\User\GDO_User;

final class GDT_PollOutcome extends GDT_Paragraph
{
	
	use WithGDO;
	
	public function renderHTML(): string
	{
		$tVars = [
			'field' => $this,
			'gdo' => $this->getChoice(),
		];
		return GDT_Template::php('Poll', 'polloutcome_html.php', $tVars);
	}
	
	public function getChoice(): GDO_PollChoice
	{
		return $this->getGDO();
	}
	
	public function renderOwnVoteIcon(): string
	{
		$icon = 'question';
		$choice = $this->getChoice();
		$poll = $choice->getPoll();
		$user = GDO_User::current();
		if ($poll->hasAnswered($user))
		{
			$icon = $choice->hasUserChosen($user) ? 'check' : 'stop';
		}
		return GDT_Icon::iconS($icon);
	}
}
