<?php
namespace GDO\Poll\tpl;

use GDO\Poll\GDO_Poll;
use GDO\Table\GDT_ListItem;
use GDO\UI\GDT_Link;

/** @var $gdo GDO_Poll * */

$li = GDT_ListItem::make('poll_' . $gdo->getID());
$li->gdo($gdo)->creatorHeader();
$li->titleRaw($gdo->renderTitle());

$li->addFields(
	$gdo->gdoColumn('poll_description'),
);

$li->actions()->addFields(
	GDT_Link::make('view_poll')->href($gdo->hrefView())->text('btn_view'),
	GDT_Link::make('answer_poll')->href($gdo->hrefAnswer())->text('btn_participate'),
);

echo $li->render();
