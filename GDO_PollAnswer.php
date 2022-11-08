<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\User\GDO_User;
use GDO\User\GDT_User;
use GDO\Core\GDT_Object;
use GDO\Core\GDT_CreatedAt;

final class GDO_PollAnswer extends GDO
{
	
	public function isTestable(): bool
	{
		return false;
	}
	
	public function gdoColumns() : array
	{
		return [
			GDT_User::make('answer_user')->primary(),
			GDT_Object::make('answer_choice')->primary()->table(GDO_PollChoice::table()),
			GDT_CreatedAt::make('answer_created'),
		];
	}
	
	##############
	### Static ###
	##############
	public static function hasAnswered(GDO_User $user, GDO_Poll $poll): bool
	{
		return self::table()->select('1')
			->joinObject('answer_choice')
			->where("answer_user={$user->getID()} AND choice_poll={$poll->getID()}")
			->first()
			->exec()
			->fetchValue() === '1';
	}
	
}
