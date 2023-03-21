<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_Object;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

final class GDO_PollAnswer extends GDO
{

	public static function hasAnswered(GDO_User $user, GDO_Poll $poll): bool
	{
		return self::table()->select('1')
				->joinObject('answer_choice')
				->where("answer_user={$user->getID()} AND choice_poll={$poll->getID()}")
				->first()
				->exec()
				->fetchValue() === '1';
	}

	public static function hasUserChosen(GDO_User $user, GDO_PollChoice $choice): bool
	{
		return !!self::getById($user->getID(), $choice->getID());
	}

	public static function clearPollFor(GDO_User $user, GDO_Poll $poll): int
	{
		$ids = [];
		$choices = $poll->getChoices();
		foreach ($choices as $choice)
		{
			$ids[] = $choice->getID();
		}
		$ids = implode(',', $ids);
		return self::table()->deleteWhere("answer_user={$user->getID()} AND answer_choice IN ($ids)");
	}

	##############
	### Static ###
	##############

	public static function calculateUserCount(GDO_Poll $poll): int
	{
		return self::table()
			->select("COUNT(DISTINCT('answer_user'))")
			->joinObject('answer_choice')
			->where("choice_poll={$poll->getID()}")
			->exec()
			->fetchValue();
	}

	public static function calculateChoiceCount(GDO_PollChoice $choice): int
	{
		return self::table()->countWhere("answer_choice={$choice->getID()}");
	}

	public function isTestable(): bool
	{
		return false;
	}

	public function gdoCached(): bool
	{
		return false;
	}

	public function gdoColumns(): array
	{
		return [
			GDT_User::make('answer_user')->primary(),
			GDT_Object::make('answer_choice')->primary()->table(GDO_PollChoice::table()),
			GDT_CreatedAt::make('answer_created'),
		];
	}

}
