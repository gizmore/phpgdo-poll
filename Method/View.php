<?php
namespace GDO\Poll\Method;

use GDO\Core\GDO;
use GDO\Poll\GDO_Poll;
use GDO\Poll\MethodPoll;
use GDO\UI\GDT_Card;
use GDO\UI\MethodCard;

final class View extends MethodCard
{

	use MethodPoll;

	public function gdoTable(): GDO
	{
		return GDO_Poll::table();
	}

    private function getPoll(): GDO_Poll
    {
        return $this->getObject();
    }

    protected function createCard(GDT_Card $card): void
    {
        $poll = $this->getPoll();
        $card->creatorHeader();
        $card->titleRaw($poll->renderTitle());
    }

}
