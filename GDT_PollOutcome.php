<?php
namespace GDO\Poll;

use GDO\UI\GDT_Paragraph;
use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;

final class GDT_PollOutcome extends GDT_Paragraph
{
	
	use WithGDO;
	
	public function renderHTML(): string
	{
		$tVars = [
			'field' => $this,
			'gdo' => $this->getGDO(),
		];
		return GDT_Template::php('Poll', 'polloutcome.php', $tVars);
	}
	
}
