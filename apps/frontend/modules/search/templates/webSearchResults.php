<div class="qfEntryHeader"><span>Browse Search Reports / Import Session 20.03.2014 / Шумленско</span></div>
<div class="qfEntryContent">
	<div class="qfSessHolder qfMaxWd qfSearchRes">					
		<div class="qfSearchWrap">
			<div class="qfSearchTag">
				<div class="qfTrMarkContainer">
					<div class="qfTrMarkCell qfTrMarkHeading qfMidHeadingBgr">Резултати от търсене (<?php echo $count?>)</div>
				</div>
			</div>
			<div class="qfSearchListWrap qfBoxBorderBg">
				<div class="qfRepImpSsItem qfRepImpSsItemColTitle">
					<div class="qfRepImpSsCol qfRepImpSsColFr">Марка</div>
					<div class="qfRepImpSsCol">Съвпадение по следната информация</div>
				</div>
				
				<?php foreach($pager->getResults() as $doc):
				//var_dump(get_class($doc));
				/*for($n = 1 ; $n <= $doc->ViennaClasses_cnt; $n++ )
				{
					$fld = "ViennaClasses".$n;
					echo $doc->$fld;
					echo "<br>";
				}*/
				?>
					<a href="<?php echo UtilsHelper::cleanURL(Document::getDocumentInstance($doc->did))?>">
						<div class="qfRepImpSsItem">
							<div class="qfRepImpSsCol qfRepImpSsLeft">
								<div class="qfRepImpSsColInn">
									<?php

									$img = Document::getDocumentInstance($doc->did);
									$img = Document::getDocumentInstance($img->getImage());
									if($img->getRelativeThumbUrl()){
									?>
									<div class="qfRepImpSsColInnImg"><img alt="trade name" src="<?php echo $img->getRelativeThumbUrl();?>"></div>
										<?php }else{?>
										<div class="qfRepImpSsColInnImg"><img alt="trade mark" src="/images/trade-mark00.jpg"></div>
										<?php } ?>
									<div class="qfRepImpSsColInnName"><h3><?php echo $doc->Label?></h3></div>
								</div>
							</div>
							<div class="qfRepImpSsCol qfRepImpSsRight">
								<div class="qfRepImpSsColInn">
									<div class="qfRepImpSsColInnName"><?php foreach ($searchOf as $k=>$f):?><p><?php echo UtilsHelper::Localize(strtolower($k))?></p><?php endforeach;?></div>
								</div>
							</div>
						</div>
					</a>
				<?php endforeach;?>
				
				
			</div>
		</div>
	</div>
</div>
