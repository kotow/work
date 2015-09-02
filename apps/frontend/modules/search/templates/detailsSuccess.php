<?php if ($brand):

?>
		<div class="qfEntryHeader"><span>Tracked Trademarks / Details / <?php echo $brand->getLabel(); ?></span></div>
			<div class="qfEntryContent">
                <div class="qfSessHolder qfMaxWd">
                    <div class="qfSessCell qfSessFullBlock qfSessHeading"><h1><?php 
					$brands_out = array('text'=>'Словна','image'=>'Фигуративна', 'mixed' => 'Комбинирана', '3d' => '3D', 'sound' => 'Звукова');
					echo $brand->getLabel().' ('.$brands_out[$brand->getKind()].')';?></h1></div>
                    <div class="qfSess21ColWrap">
                        <div class="qfSess2ColWrap">
                            <div class="qfSess11ColWrap">
                                <div class="qfSess50ColWrap qfSessCell <?php if(array_intersect(array('Label','RightsOwner', 'RightsRepresentative'), $searchOf)):?>qfRedBorderCell<?php endif;?>">
                                    <div class="qfSessBlockHeading"><h3>Легална информация</h3></div>
                                    <div class="qfSessBlockCnt">
                                        <p><b>Наименование:</b> <?php echo $brand->getLabel(); ?></p>
                                        <p><b>Притежател:</b> <?php echo $brand->getRightsOwner(); ?>, <br/><?php echo $brand->getRightsOwnerAddress(); ?></p>
                                        <p><b>Представител:</b> <?php echo $brand->getRightsRepresentative(); ?>, <br/><?php echo $brand->getRightsRepresentativeAddress(); ?></p>
                                    </div>
                                </div>
                                <div class="qfSess50ColWrap qfSess50ColWrapAdd qfSessCell <?php if(array_intersect(array('ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'Status'), $searchOf)):?>qfRedBorderCell<?php endif;?>">
                                    <div class="qfSessBlockHeading"><h3>Регистрационна информация</h3></div>
                                    <div class="qfSessBlockCnt">
                                        <p><b>Заявка Номер:</b> <?php echo $brand->getApplicationNumber(); ?></p>
                                        <p><b>Дата на заявяване:</b> <?php echo $brand->getApplicationDate() ? UtilsHelper::Date($brand->getApplicationDate(), 'd.m.Y') : '-'; ?></p>
                                        <p><b>Регистров номер:</b> <?php echo $brand->getRegisterNumber(); ?></p>
                                        <p><b>Дата на регистриране:</b> <?php echo $brand->getRegistrationDate() ? UtilsHelper::Date($brand->getRegistrationDate(), 'd.m.Y') : '-'; ?></p>
                                        <p><b>Статус:</b> <?php echo $brand->getStatus(); ?></p>
                                        <p><b>Срок:</b> <?php echo $brand->getExpiresOn() ? UtilsHelper::Date($brand->getExpiresOn(), 'd.m.Y') : '-'; ?></p>
                                    </div>
                                </div>
                            </div>
                           	
                            <div class="qfSessFullSubColWrap qfSessCell qfSessCellRevStyle">
                                <div class="qfSessBlockHeading"><h3>Краен срок за опозиция</h3></div>
                                <div class="qfSessBlockCnt">
                                    <?php echo UtilsHelper::Date($brand->getContestation(), 'd.m.Y');?>
                                </div>
                            </div>
                            
                            <div class="qfSessFullSubColWrap qfSessCell <?php if(array_intersect(array('NiceClasses'), $searchOf)):?>qfRedBorderCell<?php endif;?>">
                                <div class="qfSessBlockHeading"><h3>Класификации</h3></div>
                                <div class="qfSessBlockCnt">
                                    <h3>Класове по Ницската класификация:</h3>

<?php $classes = $brand->getNiceClasses() ? explode(',', $brand->getNiceClasses()) : array(); ?>
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
                            <div class="qfSessFullColWrap qfSessCell <?php if(array_intersect(array('ViennaClasses'), $searchOf)):?>qfRedBorderCell<?php endif;?>">
                                <div class="qfSessBlockHeading"><h3>Изображение</h3></div>
                                <div class="qfSessBlockCnt">
                                    <div class="qfSessLogoContainer">
<?php
$src = '/images/trade-mark00.jpg';
$src2 = '/images/trade-mark00.jpg';
if ( $img = $brand->getImage())
{
	$src = '/media/upload/'.$img.'.jpg';
	$src2 = '/media/upload/'.$img.'.jpg';
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
                                    <?php echo $brand->getColors(); ?></p>
                                    <p><h4>Класове по Виенската класификация:</h4>
                                    <?php
                                    $cls = implode(" | ", explode(",", $brand->getViennaClasses()));
                                    echo $cls ?></p>
                                    </div>  
                                </div>
                            </div>
                            <div class="qfSessFullColWrap qfSessCell qfSessCellMArTop <?php if(array_intersect(array('Kind','DesignatedContractingParty'), $searchOf)):?>qfRedBorderCell<?php endif;?>">
                                <div class="qfSessBlockHeading"><h3>Друга информация</h3></div>
                                <div class="qfSessBlockCnt">
                                    <div>
                                        <p><b>Тип:</b> <?php echo $brand->getKind(); ?></p>
                                        <!-- <p><b>Вид:</b> ---</p> -->
                                        <p><b>Държави в които е в сила:</b> <?Php echo $brand->getDesignatedContractingParty(); ?></p>
                                        <!-- <p><b>Незащитени елементи:</b> ---</p> -->
                                    </div>  
                                </div>
                            </div>
 <?php
if ($parentBrand):

$src = '/images/trade-mark00.jpg';
$src2 = '/images/trade-mark00.jpg';
if ( $img = Document::getDocumentInstance($parentBrand->getImage()) )
{
	$src = $img->getRelativeThumbUrl();
	$src2 = $img->getAbsoluteUrl();
}
?>
                            <div class="qfSessFullColWrap qfSessCell qfSessCellMArTop qfSearchMatch">
                                <div class="qfSessBlockHeading"><h3>За следена марка</h3></div>
                                <div class="qfSessBlockCnt">
                                    <div class="qfSessLogoContainer">
                                        <a href="<?php echo $src2; ?>" target="_blank"><img src="<?php echo $src; ?>" alt="logo" /></a>
                                        <div class="qfSearchMatchData">
                                        	<p><b>Име: </b>"<?php echo $parentBrand->getLabel() ?>"</p>
                                            <p><b>Регистров номер: </b>"<?php echo $parentBrand->getRegisterNumber() ?>"</p>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="qfSessColorsContainer">
                                        <img src="/images/color-scheme.jpg" alt="colors" />
                                    </div>
                                    -->
                                    
                                    <div class="qfSearchMatchParams">
                                    <h4>Търсене по:</h4>
                                    <?php /*
                                    $forbidden = array( 'Id', 'CreatedAt', 'UpdatedAt', 'PublicationStatus' );
                                    
                                    foreach (Schema::getSearchProperties() as $prop):
                                    $getter = "get".$prop;
                                    if(!$st->$getter()) continue;
                                    if(in_array($prop, $forbidden)) continue;*/
                                    ?>
                                    	<p><b><?php echo $prop?>: </b>"<?php/* echo $st->$getter() */?>"</p>
                                    <?php/* endforeach;*/?>
                                    </div>  
                                </div>
                            </div><!-- -->
                            
<?php endif;?>
                        </div>
                    </div>
                    <div class="qfSessMainCtrls">
                        <a href="import-session-report.html?is=<?php /*echo $sm->getImportSession()."&del=".$sm->getId()*/?>" class="qfSessCtrlBtn qfSessCtrlDark">Изтрий</a>
                    </div>
                </div>
            </div>
<?php else: ?>
		<div class="qfEntryHeader">
        	<span style="color: #ff0000;">Грешка: Неправилен Trademark обект!</span>
        </div>
<?php endif; ?>
