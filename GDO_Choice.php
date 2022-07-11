<?php
namespace GDO\Poll;

use GDO\Core\GDO;
use GDO\Core\GDT_Object;
use GDO\Core\GDT_AutoInc;
use GDO\UI\GDT_Title;
use GDO\DB\GDT_Index;

final class GDO_Choice extends GDO
{
	public function gdoColumns() : array
	{
		return array(
			GDT_AutoInc::make('choice_id'),
			GDT_Object::make('choice_poll')->table(GDO_Poll::table())->notNull(),
			GDT_Title::make('choice_text')->notNull(),
		    GDT_Index::make('choice_poll_index')->indexColumns('choice_poll')->hash(),
		);
	}

	
}
