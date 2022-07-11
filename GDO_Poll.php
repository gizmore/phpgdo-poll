<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_CreatedAt;
use GDO\UI\GDT_Title;
use GDO\Language\GDT_Language;
use GDO\Core\GDT_Checkbox;

final class GDO_Poll extends GDO
{
	public function gdoColumns() : array
	{
		return array(
			GDT_AutoInc::make('poll_id'),
			
			GDT_Title::make('poll_question')->notNull(),
			GDT_Language::make('poll_language')->notNull()->initial('en'),
			
			GDT_Checkbox::make('poll_multiple_choice')->notNull()->emptyInitial(t('choose_multiple_choice')),
			
			GDT_CreatedBy::make('poll_creator'),
			GDT_CreatedAt::make('poll_created'),
		);
	}
	
}
