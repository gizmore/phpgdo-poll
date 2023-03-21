<?php
namespace GDO\Poll\Method;

use GDO\Core\GDO;
use GDO\Poll\GDO_Poll;
use GDO\Poll\MethodPoll;
use GDO\UI\MethodCard;

final class View extends MethodCard
{

	use MethodPoll;

	public function gdoTable(): GDO
	{
		return GDO_Poll::table();
	}

}
