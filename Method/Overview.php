<?php
namespace GDO\Poll\Method;

use GDO\Table\MethodQueryList;
use GDO\Core\GDO;
use GDO\Poll\GDO_Poll;
use GDO\Poll\MethodPoll;

/**
 * Overview of Polls.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.10
 */
final class Overview extends MethodQueryList
{
	use MethodPoll;
	
	public function gdoTable() : GDO { return GDO_Poll::table(); }

	public function getTableTitle()
	{
		return t('link_polls', [
			$this->getTable()->countItems(),
		]);
	}
	
}
