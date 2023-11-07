<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ano Rangga Rahardika <rahardikaku@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CallAnalytic\AppInfo;

use OCP\AppFramework\App;


class Application extends App {
	public const APP_ID = 'callanalytic';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

}
