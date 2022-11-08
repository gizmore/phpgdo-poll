<?php
namespace GDO\Poll\tpl;
use GDO\Table\GDT_ListItem;
use GDO\UI\GDT_Link;

/** @var $gdo \GDO\Poll\GDO_Poll **/

$li = GDT_ListItem::make('poll_'.$gdo->getID());
$li->gdo($gdo)->creatorHeader();
$li->titleRaw($gdo->renderTitle());

$li->addFields(
	$gdo->gdoColumn('poll_description'),
);

$li->actions()->addFields(
	GDT_Link::make('view_poll')->href($gdo->hrefView()),
	GDT_Link::make('answer_poll')->href($gdo->hrefAnswer()),
);

echo $li->render();
