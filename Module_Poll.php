<?php
namespace GDO\Poll;

use GDO\Core\GDO_Module;

final class Module_Poll extends GDO_Module
{
	public int $priority = 40;
	
	public function getClasses() : array
	{
		return array(
			"GDO\\Poll\GDO_Poll",
			"GDO\\Poll\GDO_Choice",
			"GDO\\Poll\GDO_Answer",
		);
	}
}
