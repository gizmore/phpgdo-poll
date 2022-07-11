<?php
namespace GDO\Poll\Method;

use GDO\Table\MethodQueryList;
use GDO\Poll\GDO_Poll;

/**
 * Overview of Polls.
 * @author gizmore
 * @since 6.10
 */
final class Overview extends MethodQueryList
{
	public function gdoTable() { return GDO_Poll::table(); }

}
