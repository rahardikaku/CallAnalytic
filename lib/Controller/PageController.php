<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ano Rangga Rahardika <rahardikaku@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CallAnalytic\Controller;

use OCA\CallAnalytic\AppInfo\Application;
use OCA\CallAnalytic\Service\CallAnalyticService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;
use OCP\IUserSession;
use Phplot\Phplot\phplot;

class PageController extends Controller {
    /** @var IConfig */
    protected $config;
    /** @var IUserSession */
    private $userSession;
	/** @var CallAnalyticService */
	private $callAnalyticService;
  

	public function __construct(
        IRequest $request,
        IUserSession $userSession,
		CallAnalyticService $callAnalyticService
	) {
		parent::__construct(Application::APP_ID, $request);
        $this->userSession = $userSession;
		$this->callAnalyticService = $callAnalyticService;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index(): TemplateResponse {
		Util::addScript(Application::APP_ID, 'callanalytic-main');
		$params = array();
		$user = $this->userSession->getUser();
		// $total_count = $this->callAnalyticService->initiateTotalCountChat($user);
		$time_series = $this->plotTimeSeries($user);
		$params['total_count'] = $total_count;
		$params['time_series'] = $time_series;
		// var_dump($time_series);
        try {
            $translationAvailable = \OCP\Server::get(\OCP\Translation\ITranslationManager::class)->hasProviders();
            $translationLanguages = \OCP\Server::get(\OCP\Translation\ITranslationManager::class)->getLanguages();
        } catch (\Exception $e) {
            $translationAvailable = false;
            $translationLanguages = false;
        }
		return new TemplateResponse(Application::APP_ID, 'main',$params);
	}

	public function plotTimeSeries($user){
		require __DIR__.'./../Phplot/phplot.php';
		$data_timeseries = $this->callAnalyticService->initTimeSeriesData($user);
		$data = array();
		// var_dump($data_timeseries);
		$nineDaysAgo = date("Y-m-d", strtotime("-9 days"));
		//throw new \Exception( "\$data = $nineDaysAgo" ); 
		for ($i = 0; $i < 10; $i++) {
			$count_in = 0;
			$count_out = 0;
			foreach($data_timeseries as $ts){
				if ($ts['tanggal'] === $nineDaysAgo){
					$count_in = $ts['count_in'];
					$count_out = $ts['count_out'];
				}
			}
			$data[]=array($nineDaysAgo,$count_in,$count_out);
			$nineDaysAgo = date("Y-m-d", strtotime("+1 day", strtotime($nineDaysAgo)));
		}
		$p = new phplot(1000,500);
		$p->SetDataValues($data);
		$p->SetXTickLabelPos('none');
		$p->SetXTickPos('none');
		$p->SetDrawXGrid(True);
		$p->SetDrawYGrid(True);
		$p->SetXTitle('Tanggal');
		$p->SetYTitle('Jumlah');
		$p->SetXLabelFontSize(5);
		$p->SetYTickIncrement(1);
		$p->SetDataColors(array('blue','red'));
		$p->SetLegend(array('Masuk','Keluar'));
		$p->SetLineStyles('solid');
		$p->SetPlotType('lines');
		$p->SetIsInline(True);
		$p->SetOutputFile("lines.png"); 
		$p->DrawGraph();
		return $p->EncodeImage();
		//return 'he';
     }

}