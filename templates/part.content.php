<?php
/**
 * Analytics
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the LICENSE.md file.
 *
 * @author Marcel Scherello <analytics@scherello.de>
 * @copyright 2019-2022 Marcel Scherello
 */
?>
<div id="analytics-content" style="width:100%; padding: 20px 5%;" hidden>
    <input type="hidden" name="sharingToken" value="<?php p($_['token']); ?>" id="sharingToken">
    <input type="hidden" name="dataset" value="" id="datasetId">
    <input type="hidden" name="advanced" value="false" id="advanced">
    <h2 id="reportHeader"></h2>
    <h3 id="reportSubHeader" hidden></h3>
    <div id="reportPlaceholder"></div>
    <?php print_unescaped($this->inc('part.menu')); ?>
    <div id="chartContainer">
    </div>
    <div id="chartLegendContainer">
        <div id="chartLegend" class="icon icon-menu">Chat Coofis Analytic</div>
    </div>
    <div id="tableSeparatorContainer"></div>
  
    <table id="tableContainer"></table>
    <div id="noDataContainer" hidden>
        <?php p($l->t('No data found')); ?>
    </div>
</div>
<div id="analytics-intro" style="padding: 30px" hidden>
    <div>
      <ul id="ulQuickstart" style="width: 100%;text-align:center;">
             <li style="display: inline-block; margin: 10px;">
                <div class="infoBox" id="infoBoxIntro"><img
                            src="<?php echo \OC::$server->getURLGenerator()->imagePath('callanalytic', 'arrowDown.svg') ?>"
                            alt="incomiingCount">
		    <div class="infoBoxHeader">
			<?php p($l->t('Jumlah Panggilan Masuk')); ?></br>
			<span style="font-weight:600;color:#800000;font-size:20pt;">
				<?php 
					if ($_['total_count']['count_in']){
						p($_['total_count']['count_in']);
					}else{
						p(0);
					}
				?>
			</span>
		   </div>
		</div>
	    </li>
	    <li style="display: inline-block; margin: 10px;">
		<div class="infoBox" id="infoBoxIntro">
                    <img
                       src="<?php echo \OC::$server->getURLGenerator()->imagePath('callanalytic', 'forecast.svg') ?>"
                      alt="outgoingCount">
		    <div class="infoBoxHeader">
			<?php p($l->t('Jumlah Panggilan Keluar')); ?><br/>
		    	<span style="font-weight:600;color:#800000;font-size:20pt;">
				<?php 
					if ($_['total_count']['count_out']){
						p($_['total_count']['count_out']);
					}else{
						p(0);
					}
				?>
		       </span>
		  </div>
		</div>
	    </li>
             <li style="display: inline-block; margin: 10px;">
		<div class="infoBox" id="infoBoxIntro">
                    <img
                       src="<?php echo \OC::$server->getURLGenerator()->imagePath('callanalytic', 'infoReport.svg') ?>"
                      alt="totalCount">

		    <div class="infoBoxHeader">
			<?php p($l->t('Jumlah Total Panggilan')); ?><br/>
			<span style="font-weight:600;color:#800000;font-size:20pt;">
				<?php 
					if ($_['total_count']['count_total']){
						p($_['total_count']['count_total']);
					}else{
						p(0);
					}
				?>
			</span>
		    </div>
		</div>
            </li>
      </ul>
      <h2 style="text-align:center;margin-top:15px;color:#800000;">Time Series Data 10 Hari Terakhir</h2>
      <img style="display:block;margin-left:auto;margin-right:auto;" src="<?php p($_['time_series'])?>"/>
    </div>
    <br>
</div>
