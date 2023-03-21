<?php
namespace GDO\Poll\tpl;

use GDO\Poll\GDO_PollChoice;
use GDO\Poll\GDT_PollOutcome;

/** @var $field GDT_PollOutcome * */
/** @var $gdo GDO_PollChoice * */
?>
<div class="gdt-poll-outcome">
    <label><?=$field->renderOwnVoteIcon()?><?=$gdo->renderTitle()?></label>
    <table>
        <tr>
            <td><?=$gdo->getAmount()?></td>
            <td>
                <em></em>
                <em style="width: <?=$gdo->getPercent()?>%;"></em>
            </td>
            <td><?=$gdo->renderPercent()?></td>
        </tr>
    </table>
</div>
