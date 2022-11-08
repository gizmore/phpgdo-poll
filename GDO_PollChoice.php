<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\UI\GDT_Title;
use GDO\Core\GDT_Index;
use GDO\Core\GDT_Percent;
use GDO\Core\GDT_UInt;

final class GDO_PollChoice extends GDO
{
	
	public function isTestable(): bool
	{
		return false;
	}
	
	public function gdoColumns() : array
	{
		return [
			GDT_AutoInc::make('choice_id'),
			GDT_Poll::make('choice_poll')->notNull(),
			GDT_UInt::make('choice_amount')->bytes(2)->notNull()->initial('0'),
			GDT_Percent::make('choice_percent'),
			GDT_Title::make('choice_text')->notNull()->min(1),
		    GDT_Index::make('choice_poll_index')->indexColumns('choice_poll')->hash(),
		];
	}

	public function getAmount(): int
	{
		return $this->gdoVar('choice_amount');
	}
	
	public function renderPercent(): string
	{
		return $this->gdoDisplay('choice_percent');
	}
	
	public function renderTitle() : string
	{
		return $this->gdoDisplay('choice_text');
	}
	
	##############
	### Static ###
	##############
	public static function getChoices(GDO_Poll $poll, string $order='RAND()'): array
	{
		return GDO_PollChoice::table()->select()
			->where("choice_poll={$poll->getID()}")
			->order($order)
			->exec()
			->fetchAllArray2dObject();
	}
	
}
