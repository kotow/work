<h1 class="content-heading"><span><?php echo UtilsHelper::Localize("website.frontend.Contact_title")?></span></h1>
<div class="content">
	
 	<h3>Quote Form</h3>

    <form id="quote_form" method="POST">
    	<div class="form-holder">
    	<?php if (!$success):?>
    	
    		<!--<div id="flashMsg"></div>-->
    		<div class="field">
    			<label>Full Name <span class="obligated">*</span></label>
    			<?php echo frontend_input("full_name", null, array('class'=>'large'))?>
    		</div>
    
    		<div class="field">
    			<label>E-mail <span class="obligated">*</span></label>
    			<?php echo frontend_input("email", null, array('class'=>'large'))?>
    		</div>    
    
    		<div class="field">
    			<label>Address <span class="obligated">*</span></label>
    			<?php echo frontend_input("adress", null, array('class'=>'large'))?>
    		</div>    
    
    		<div class="field">
    			<label>City <span class="obligated">*</span></label>
    			<?php echo frontend_input("city", null, array('class'=>'large'))?>
    		</div> 
            
    		<div class="field">
    			<label>Zip Code <span class="obligated">*</span></label>
    			<?php echo frontend_input("zip", null, array('class'=>'large'))?>
    		</div>             
            
    		<div class="field">
    			<label>State <span class="obligated">*</span></label>
    			<?php echo frontend_input("state", null, array('class'=>'large'))?>
    		</div> 
            
    		<div class="field">
    			<label>Home Phone </label>
    			<?php echo frontend_input("home_phone", null, array('class'=>'large'))?>
    		</div>             
            
    		<div class="field">
    			<label>Cell Phone <span class="obligated">*</span></label>
    			<?php echo frontend_input("cell_phone", null, array('class'=>'large'))?>
    		</div>    
            
    		<div class="field">
    			<label>Date of Opening <span class="obligated">*</span></label>
    			<?php //echo frontend_input("date_open", "YYYY-MM-DD", array('class'=>'small'),)?>
    			<?php echo frontend_date("date_open", null, array('class'=>'small','rich'=>'true'))?>
    		</div>              
            
    		<div class="field">
    			<label>Date of Closing </label>
    			<?php echo frontend_date("date_close", null, array('class'=>'small','rich'=>'true'))?>
    		</div>              
            
    		<div class="field">
    			<label>Service Request <span class="obligated">*</span></label> 
            	<?php echo frontend_select("service", null, Lists::getListitemsForSelect("requests", array(""=>"Quote")), array("class"=>"serv"))?>
    		</div>
    		
    		<div class="field">
    			<label></label><img src="/user/captcha">
    		</div>
    		    
    		<div class="field">
    			<label>Security </label>
    			<?php echo frontend_input("captcha", null, array('class'=>'small'))?>
           		<p style="margin-left:125px">Please, do smth that will prove you are not a robot</p>
    		</div>              
    	
    		<input type='hidden' value='submitted' name="submitted"/>
       		<p class="no-border"><a class="button-cont" title="#" href="#" onclick="$('#quote_form').submit();"><span>Send the Quote</span></a></p>
        
        <?php else:?>
        
	        <h3>Thank You</h3>
	      	<p>Your Quote was successfully sent.</p>
	       	<p>You will recieve an answer shortly</p><br>
	       	
    	<?php endif;?>
    	</div> 
    </form>
    <br class="clear" />
              
</div>    