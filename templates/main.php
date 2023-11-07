<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ano Rangga Rahardika <rahardikaku@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

use OCP\Util;

Util::addStyle('callanalytic', 'style');
Util::addStyle('callanalytic', 'sharetabview');
Util::addStyle('callanalytic', '3rdParty/datatables.min');
Util::addStyle('files_sharing', 'icons');
Util::addStyle('callanalytic', 'dashboard');
Util::addStyle('callanalytic', 'wizard');
Util::addStyle('callanalytic', 'print');
Util::addScript('callanalytic', 'app');
// Util::addScript('callanalytic', 'sidebar');
// Util::addScript('callanalytic', 'navigation');
Util::addScript('callanalytic', 'filter');
Util::addScript('callanalytic', '3rdParty/datatables.min');
Util::addScript('callanalytic', '3rdParty/chart.min');
Util::addScript('callanalytic', '3rdParty/chartjs-adapter-moment');
Util::addScript('callanalytic', '3rdParty/chartjs-plugin-datalabels.min');
Util::addScript('callanalytic', '3rdParty/chartjs-plugin-zoom.min');
Util::addScript('callanalytic', '3rdParty/moment');
Util::addScript('callanalytic', '3rdParty/cloner');
// Util::addScript('callanalytic', 'dashboard');
// Util::addScript('callanalytic', 'userGuidance');
?>

<div id="app-content">
    <div id="loading">
        <i class="ioc-spinner ioc-spin"></i>
    </div>
    <?php print_unescaped($this->inc('part.content')); ?>
</div>
?>

