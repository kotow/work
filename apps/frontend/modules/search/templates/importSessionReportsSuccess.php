
<div class="qfEntryHeader"><span>Browse Search Reports / Import Session #<?php echo $sf_params->get('is');?><span class='qfCountTrademarks'>(<?=count($pager->getResults())?>)</span></span></div>
<div class="qfEntryContent">
	<div class="qfSessHolder qfMaxWd qfImpReport">
		<div class="qfSearchWrap">
			<div class="qfSearchTag">
				<div class="qfTrMarkContainer">
					<div class="qfTrMarkCell qfTrMarkHeading qfMidHeadingBgr">Доклад по <?php if($is) echo $is->getLabel()?></div>
				</div>
			</div>
			<div class="qfSearchListWrap qfBoxBorderBg">
				
				<form method="POST">
				<input type="submit" value="Изтрий избрани" style="float:left"/>
				<br />
				<br />

				<?php
				$fields =  array('Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty');
				foreach($pager->getResults() as $doc):
				$brand = Document::getParentOf($doc->getSearch(), "Brand");
				if(!$brand) continue;
				?>
					
						<div class="qfRepImpSsItem">

							<div class="qfRepImpSsCol qfRepImpSsLeft">
								<div class="qfRepImpSsColInn">
								
								<div class="check_delete"><input type="checkbox" name="del[]" value="<?php echo $doc->getId()?>"></div>
								
								<!--<a href="import-session-report.html?is=<?php echo $sf_params->get('is')."&del=".$doc->getId()?>" class="qfSessCtrlBtn qfSessCtrlDark" style="float: left;"></a>-->
								<a href="<?php echo UtilsHelper::cleanURL(Document::getDocumentInstance($doc->getId()))?>">
									<!--<div class="qfRepImpSsColInnImg"><img alt="trade name" src="images/trade-mark-sm01.jpg"></div>-->
									<div class="qfRepImpSsColInnName"><h3><?php
											$tm = Document::getDocumentInstance($doc->getTrademark());
											if($tm){
												$tmimg = $tm->getImage();

											if($tmimg):?>
												<img alt="trade mark" src="/media/display/id/<?php echo $tmimg?>">
											<?php else:?>
												<img alt="trade mark" src="/images/trade-mark00.jpg">
											<?php endif;
											if($tm){
												echo $tm->getLabel();
											}}
											?>
										</h3>
									</div>
								</a>
									</div>
							</div>
							<div class="qfRepImpSsCol qfRepImpSsRight">
								<div class="qfRepImpSsColInn">
									<div class="qfRepImpSsColInnName">
									
									<p>
									
									<?php 
									$template = Document::getDocumentInstance($doc->getSearch());
									if($template) 
									{
										
										$searchOf = array();
										foreach ($fields as $field)
										{
											$getter = "get".$field;
											$v = $template->$getter();
											if($v) $searchOf[] = $field;
										}
									}
									$img = null;
									
									if($brand):
									$img = $brand->getImage();
									if($img):?>
										<img alt="trade mark" src="/media/display/id/<?php echo $img?>">
									<?php else:?>
										<img alt="trade mark" src="/images/trade-mark00.jpg">
									<?php endif;?>
										<?php echo $brand->getLabel() ;?>
									<?php endif;?>
									</p>
									<?php/*
									foreach ($searchOf as $f):
									?><p><img alt="trade mark" src="/images/trade-mark00.jpg"><?php echo UtilsHelper::Localize(strtolower($f))?></p>
									<?php endforeach;*/?>

									</div>
								</div>
							</div>
							<div class="qfRepImpSsCol qfRepImpSsRight">
								<?php
									foreach ($searchOf as $f):
									?><p><?php echo UtilsHelper::Localize(strtolower($f))?></p>
									<?php endforeach;?>
							</div>
						</div>
					
				<?php endforeach;?>
				<!--<a href="import-session-highlight.php">
					<div class="qfRepImpSsItem">
						<div class="qfRepImpSsCol qfRepImpSsLeft">
							<div class="qfRepImpSsColInn">
								<div class="qfRepImpSsColInnImg"><img src="images/trade-mark-sm01.jpg" alt="trade name" /></div>
								<div class="qfRepImpSsColInnName"><h3>Карлисберг</h3></div>
							</div>
						</div>
						<div class="qfRepImpSsCol qfRepImpSsRight">
							<div class="qfRepImpSsColInn">
								<div class="qfRepImpSsColInnImg"><img src="images/trade-mark-sm04.jpg" alt="trade name" /></div>
								<div class="qfRepImpSsColInnName"><h3>Carlsberg</h3></div>
							</div>
						</div>
					</div>
				</a>-->
			</form>
			</div>
		</div>
	</div>
</div>
