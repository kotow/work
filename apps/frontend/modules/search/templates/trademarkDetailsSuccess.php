<?php if ($trademark): ?>
		<div class="qfEntryHeader"><span>Tracked Trademarks / Details / <?php echo $trademark->getLabel(); ?></span></div>
			<div class="qfEntryContent">
                <div class="qfSessHolder qfMaxWd">
                    <div class="qfSessCell qfSessFullBlock qfSessHeading"><h1><?php 
					$brands_out = array('text'=>'Словна','image'=>'Фигуративна', 'mixed' => 'Комбинирана', 'sound' => 'Звукова', '3d' => '3D');
					echo $trademark->getLabel().' ('.$brands_out[$trademark->getKind()].')'; ?></h1></div>
                    <div class="qfSess21ColWrap qfSessCellEqHghtHolder">
                        <div class="qfSess2ColWrap">
                            <div class="qfSess11ColWrap">
                                <div class="qfSess50ColWrap qfSessCell qfSessCellEqHght01 qfSessCellEqHght">
                                    <div class="qfSessBlockHeading"><h3>Основна информация</h3></div>
                                    <div class="qfSessBlockCnt">
                                        <p><b>Наименование:</b> <?php echo $trademark->getLabel(); ?></p>
                                        <p><b>Притежател:</b> <?php echo $trademark->getRightsOwner(); ?>, <br/><?php echo $trademark->getRightsOwnerAddress(); ?></p>
                                        <p><b>Представител:</b> <?php echo $trademark->getRightsRepresentative(); ?>, <br/><?php echo $trademark->getRightsRepresentativeAddress(); ?></p>
                                    </div>
                                </div>
                                <div class="qfSess50ColWrap qfSess50ColWrapAdd qfSessCell qfSessCellEqHght02 qfSessCellEqHght">
                                    <div class="qfSessBlockHeading"><h3>Регистрационна информация</h3></div>
                                    <div class="qfSessBlockCnt">
                                        <p><b>Заявка Номер:</b> <?php echo $trademark->getApplicationNumber(); ?></p>
                                        <p><b>Дата на заявяване:</b> <?php echo $trademark->getApplicationDate() ? UtilsHelper::Date($trademark->getApplicationDate(), 'd.m.Y') : '-'; ?></p>
                                        <p><b>Регистров номер:</b> <?php echo $trademark->getRegisterNumber(); ?></p>
                                        <p><b>Дата на регистриране:</b> <?php echo $trademark->getRegistrationDate() ? UtilsHelper::Date($trademark->getRegistrationDate(), 'd.m.Y') : '-'; ?></p>
                                        <p><b>Статус:</b> <?php echo $trademark->getStatus(); ?></p>
                                        <p><b>Срок:</b> <?php echo $trademark->getExpiresOn() ? UtilsHelper::Date($trademark->getExpiresOn(), 'd.m.Y') : '-'; ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="qfSessFullSubColWrap qfSessCell qfSessCellRevStyle">
                                <div class="qfSessBlockHeading"><h3>Краен срок за опозиция</h3></div>
                                <div class="qfSessBlockCnt">
                                    <?php echo UtilsHelper::DateBG($trademark->getContestation(), "d.m.Y")?> г.
                                </div>
                            </div>
                            
                            <div class="qfSessFullSubColWrap qfSessCell">
                                <div class="qfSessBlockHeading"><h3>Класификации</h3></div>
                                <div class="qfSessBlockCnt">
                                    <h3>Класове по Ницската класификация:</h3>
<?php $classes = $trademark->getNiceClasses() ? explode(',', $trademark->getNiceClasses()) : array(); ?>
<?php foreach ($classes as $cl): ?>
<?php $cl = intval($cl); if ($cl < 10) $cl = "0".$cl; ?>
                                    <div class="qfSessClasTable">
                                        <div class="qfSessClasCell qfSessClasNum"><span><?Php echo $cl; ?></span></div>
                                        <div class="qfSessClasCell qfSessClasTxt"><?php echo UtilsHelper::Localize("nice.class_$cl"); ?></div>
                                    </div>  
<?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="qfSess1ColWrap">
                            <div class="qfSessFullColWrap qfSessCell qfSessCellEqHght03 qfSessCellEqHght" id="qfLogo_info">
                                <div class="qfSessBlockHeading"><h3>Изображение</h3></div>
                                <div class="qfSessBlockCnt">
                                    <div class="qfSessLogoContainer">
<?php
$src = '/images/trade-mark00.jpg';
$src2 = '/images/trade-mark00.jpg';
if ( $img = Document::getDocumentInstance($trademark->getImage()) )
{
	$src = $img->getRelativeThumbUrl();
	$src2 = $img->getAbsoluteUrl();
}
?>
                                        <a href="<?php echo $src2; ?>" target="_blank"><img src="<?php echo $src; ?>" alt="logo" /></a>
                                    </div>
                                    <!--
                                    <div class="qfSessColorsContainer">
                                        <img src="/images/color-scheme.jpg" alt="colors" />
                                    </div>
                                    -->
                                    
                                    <div>
                                    <p><h4>Цветове / Colours / Farben</h4>
                                    <?php echo $trademark->getColors(); ?></p>
                                    <p><h4>Класове по Виенската класификация:</h4>
                                    <?php echo $trademark->getViennaClasses(); ?></p>
                                    </div>  
                                </div>
                            </div>
                            
                            <div class="qfSessFullColWrap qfSessCell qfSessCellMArTop">
                                <div class="qfSessBlockHeading"><h3>Друга информация</h3></div>
                                <div class="qfSessBlockCnt">
                                    <div>
                                        <p><b>Тип:</b> <?php echo $brands_out[$trademark->getKind()]; ?></p>
                                        <p><b>Вид:</b> ---</p>
                                        <p><b>Държави в които е в сила:</b> <?Php echo $trademark->getDesignatedContractingParty(); ?></p>
                                        <p><b>Незащитени елементи:</b> ---</p>
                                        <p><b>База данни:</b> <?php 
										$db_names = array(1 => 'Българско Патентно Ведомство', 2=>'OAMI', 3=>'WIPO');
										echo $db_names[$trademark->getFromSystem()]; 
										
										?></p>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="qfSessMainCtrls">
                        <a href="add-new-trademark.html?trademark_id=<?php echo$trademark->getId(); ?>" class="qfSessCtrlBtn qfSessCtrlLgt">Редактирай</a>
                        <?php /*<a class="qfSessCtrlBtn qfSessCtrlDark">Изтрий</a>*/ ?>
                    </div>

                </div>
            </div>
<?php else: ?>
		<div class="qfEntryHeader">
        	<span style="color: #ff0000;">Грешка: Неправилен Trademark обект!</span>
        </div>
<?php endif; ?>
