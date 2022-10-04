<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_CreatedAt;
use GDO\UI\GDT_Title;
use GDO\Language\GDT_Language;
use GDO\Core\GDT_Checkbox;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\Core\GDT_DeletedBy;
use GDO\Core\GDT_DeletedAt;

final class GDO_Poll extends GDO
{
	public function gdoColumns() : array
	{
		return [
			GDT_AutoInc::make('poll_id'),
			
			GDT_Title::make('poll_question')->notNull(),
			GDT_Language::make('poll_language')->notNull()->initial('en'),
			
			GDT_Checkbox::make('poll_multiple_choice')->notNull()->emptyInitial(t('choose_multiple_choice')),
			
			GDT_Date::make('poll_expires')->notNull()->maxAge(Time::ONE_YEAR),
			
			GDT_Checkbox::make('poll_guests')->initial('0'),
			
			GDT_CreatedBy::make('poll_creator'),
			GDT_CreatedAt::make('poll_created'),
		
			GDT_DeletedBy::make('poll_deletor'),
			GDT_DeletedAt::make('poll_deleted'),
		];
	}
	
	##############
	### Static ###
	##############
	public static function numActivePolls() : int
	{
		$now = Time::getDateWithoutTime();
		$conditions = "poll_deleted IS NULL AND poll_expires > '{$now}'";
		return self::table()->countWhere($conditions);
	}
	
}
