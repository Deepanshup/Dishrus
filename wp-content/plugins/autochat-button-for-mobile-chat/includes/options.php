<?php
//Plugin options page

if ( is_admin() ){
	add_action( 'admin_init', 'auytpw_register_settings' );
}

/**
 * Display menu page
 */
function auytpw_whatsapp_menu_page(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	$tpw_code = get_option('tpw_code');
	$tpw_number = get_option('tpw_number');
	$tpw_message = get_option('tpw_message');
	
	$link = auytpw_whatsapp_link($tpw_code, $tpw_number, $tpw_message);
	settings_errors();
	?>

	<div class="wrap tpw_options">
		<div class="row">
			<div class="col-6 tpw_col">
				<form method="post" action="options.php"> 
					<?php settings_fields( 'tpw_opt' ); 
						do_settings_sections( 'tpw_opt' ); 
						$msj = get_option('tpw_message');
					?>
					<h1 class="wp-heading-inline"><?php _e("Whatsapp Options", "autochat-button-for-mobile-chat"); ?></h1>
					<?php submit_button(); ?>
					
					
					<h2 class="title"><?php _e("Labels and Messages", "autochat-button-for-mobile-chat") ?></h2>
					<h4><?php _e("Whatsapp Message", "autochat-button-for-mobile-chat"); ?></h4>

					<textarea name="tpw_message" rows="5" cols="63" placeholder="<?php _e("Hi!", "autochat-button-for-mobile-chat"); ?>"><?php echo strip_tags(get_option('tpw_message')); ?></textarea>
					<div class="row">
						<div class="col">
							<h4><?php _e("Country", "autochat-button-for-mobile-chat"); ?></h4>
							<?php auytpw_countries(); ?>

							<?php
							$code = get_option('tpw_code');
							?>
						</div>
						<div class="col">
							<h4><?php _e("Phone Number", "autochat-button-for-mobile-chat"); ?></h4>
							<input class="tpw_number" type="text" placeholder="<?php _e("Number", "autochat-button-for-mobile-chat"); ?>" name="tpw_number" value="<?php echo esc_attr( get_option('tpw_number') ); ?>" />
						</div>
						
					</div>
					<hr>
					<h2 class="title"><?php _e("Widget", "autochat-button-for-mobile-chat"); ?></h2> 
					<div class="row">
						<div class="col">
							<h4><?php _e("Username", "autochat-button-for-mobile-chat"); ?></h4>
							<input type="text" name="tpw_name" value="<?php echo esc_attr( get_option('tpw_name') ); ?>" placeholder="Autochat" />
						</div>
						<div class="col">
							<h4><?php _e("Profile Image", "autochat-button-for-mobile-chat"); ?> <i><?php _e("(Square)", "autochat-button-for-mobile-chat"); ?></i></h4>
							<input type="hidden" class="tpw_upload_image" name="tpw_upload_image" value="<?php echo esc_attr( get_option('tpw_upload_image') ); ?>">
							<img class="tpw_img_stng" width="60" src="<?php echo esc_attr( get_option('tpw_upload_image') ); ?>">
							<div class="tpw_attach_btn">
								<a class="button-secondary tpw_upload_image_button" title="Attach" href="javascript:;" data-uploader_title="<?php _e("Profile Image", "autochat-button-for-mobile-chat"); ?>" data-uploader_button_text="<?php _e("Profile Image", "autochat-button-for-mobile-chat"); ?>" document_id=""><?php _e("Attach Image", "autochat-button-for-mobile-chat"); ?></a>
								<a class="button-secondary tpw_delete_image_button" title="Delete" href="javascript:;" document_id=""><?php _e("Delete") ?></a>
							</div>
							<script>
							jQuery(document).ready(function(){
								jQuery(".tpw_delete_image_button").on("click", function(){
									jQuery(".tpw_upload_image").val("");
									jQuery(".tpw_img_stng").attr("src", "");
								});
								
								jQuery(".tpw_number").on("keypress", function(e){
									if(e.which === 32){ 
										return false;
									}
								});
							});
							</script>
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							<h4><?php _e("Status", "autochat-button-for-mobile-chat"); ?></h4>
							<input type="text" name="tpw_status" value="<?php echo esc_attr( get_option('tpw_status') ); ?>" placeholder="<?php _e("Online", "autochat-button-for-mobile-chat"); ?>" />
						</div>
						<div class="col">
							<h4><?php _e("Screen Position", "autochat-button-for-mobile-chat"); ?></h4>
							<?php 
							$tpw_position = get_option('tpw_position');
							?>
							<select name="tpw_position">
								<option value="left" <?php if($tpw_position == "left"){ echo "selected";}?>><?php _e("Left", "autochat-button-for-mobile-chat"); ?></option>
								<option value="right" <?php if($tpw_position == "right"){ echo "selected";}?>><?php _e("Right", "autochat-button-for-mobile-chat"); ?></option>
							</select>
						</div>
					</div>
					
					<h4><?php _e("Intro Message", "autochat-button-for-mobile-chat") ?></h4>
					<textarea name="tpw_intro_message" rows="5" cols="63" placeholder="<?php _e("Hello! How can I help you?", "autochat-button-for-mobile-chat"); ?>"><?php echo get_option('tpw_intro_message'); ?></textarea>
		
					<div class="row">
						<div class="col">
							<h4><?php _e("Text Button", "autochat-button-for-mobile-chat") ?></h4>
							<input type="text" name="tpw_button" value="<?php echo esc_attr( get_option('tpw_button') ); ?>" placeholder="<?php _e("Start Chat", "autochat-button-for-mobile-chat"); ?>"/>
						</div>
						
						<div class="col">
						<br>
						<br>
							<input type="checkbox" name="tpw_window" <?php if(esc_attr( get_option('tpw_window') ) == "on"){ echo "checked";} ?>><span><?php _e("Don't Show Whatsapp Window", "autochat-button-for-mobile-chat"); ?></span>
						</div>
					</div>
					<div class="row tpw_button_icon">
						<div class="col">
							<h4><?php _e("Select Whatsapp Button", "autochat-button-for-mobile-chat") ?></h4>
							<div class="row">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green2-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green2-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green2-round.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green1-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green1-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green1-round.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/red-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/red-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/red-round.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/violet-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/violet-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/violet-round.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/blue-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/blue-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/blue-round.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/yellow-round.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/yellow-round.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/yellow-round.png'; ?>">
							</div>
							<div class="row">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green2-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green2-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green2-form.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green1-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green1-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green1-form.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/red-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/red-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/red-form.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/violet-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/violet-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/violet-form.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/blue-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/blue-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/blue-form.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/yellow-form.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/yellow-form.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/yellow-form.png'; ?>">
							</div>
							<div class="row">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green2-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green2-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green2-square.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/green1-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/green1-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/green1-square.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/red-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/red-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/red-square.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/violet-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/violet-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/violet-square.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/blue-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/blue-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/blue-square.png'; ?>">
								<input type="radio" name="tpw_button_style"  value="<?php echo AUYTPW_DIR .'/assets/img/yellow-square.png'; ?>" <?php if(esc_attr( get_option('tpw_button_style') ) == AUYTPW_DIR .'/assets/img/yellow-square.png'){ echo "checked";} ?> /><img class="tpw_img_button_style" src="<?php echo AUYTPW_DIR .'/assets/img/yellow-square.png'; ?>">
							</div>
						</div>
					
					</div>
					<?php submit_button(); ?>
				</form>
			</div>
			<div class="col-6 preview">
				<h2 class="title"><?php _e("Window Preview", "autochat-button-for-mobile-chat") ?></h2>
				<div class="tpwin_container" style="<?php if(esc_attr( get_option('tpw_window') ) == "on"){ echo "display: none;";}else{echo "display: block;";}?>">
					<div class="tpw_window_preview">
						<div class="close"></div>
						<div class="header ">
							<div class="photo"><img src="<?php echo get_option('tpw_upload_image');?>"></div>
							<div class="info"><p class="name"><?php if(get_option('tpw_name') == ""){ echo "Autochat"; }else{ echo get_option('tpw_name'); } ?></p>
								<p class="status"><?php if(get_option('tpw_status') == ""){ _e("Online", "autochat-button-for-mobile-chat"); }else{ echo get_option('tpw_status'); } ?></p>
							</div>
						</div>
						<div class="body">
							<div class="message"><?php if(get_option('tpw_intro_message') == ""){ _e("Hello! How can I help you?", "autochat-button-for-mobile-chat"); }else{ echo get_option('tpw_intro_message'); } ?></div>
						</div>
						<div class="footer">
							<a class="btn" href="<?php echo $link; ?>" target="_blank">
								<img src="<?php echo AUYTPW_DIR .'/assets/img/ic.png'; ?>"><span><?php if(get_option('tpw_button') == ""){ _e("Start Chat", "autochat-button-for-mobile-chat"); }else{ echo get_option('tpw_button'); } ?></span>
							</a>
							<a class="banner" target="_blank" href="https://autochat.uy/"><img src="<?php echo AUYTPW_DIR .'/assets/img/autocht.png'; ?>"></a>
						</div>
					</div>
					<div class="tpw_widget_icon <?php if(get_option('tpw_position') == "right"){ echo "right";}else{ echo "left";}?>"><a href="<?php if(esc_attr( get_option('tpw_window') ) == "on"){ echo $link;}else{echo "#";}?>" <?php if(esc_attr( get_option('tpw_window') ) == "on"){ echo "target='_blank'";} ?> ><img src="<?php if(get_option('tpw_button_style') == ""){ echo AUYTPW_DIR .'/assets/img/green2-round.png'; }else{ echo get_option('tpw_button_style'); } ?>"></a></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function auytpw_countries(){
	$tpw_code = get_option('tpw_code');
	?>
	<select name="tpw_code" class="tpw_code">
		<option data-countryCode="US" value="">Country Code</option>
		<option data-countryCode="US" value="1">USA (+1)</option>
		<option data-countryCode="GB" value="44">UK (+44)</option>
		<option disabled="disabled">Other Countries</option>
		<option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90">Cyprus - North (+90)</option>
		<option data-countryCode="CY" value="357">Cyprus - South (+357)</option>
		<option data-countryCode="CZ" value="420">Czech Republic (+420)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91">India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea - North (+850)</option>
		<option data-countryCode="KR" value="82">Korea - South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PK" value="92">Pakistan (+92)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SY" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="992">Tajikistan (+992)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		<option data-countryCode="UZ" value="998">Uzbekistan (+998)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="1">Virgin Islands - British (+1)</option>
		<option data-countryCode="VI" value="1">Virgin Islands - US (+1)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
	</select>
	<script>
		jQuery(document).ready(function(){
			<?php 
			if($tpw_code ==""){
			?>
				var tpw_code = '';
				<?php
			}else{
				?>
				var tpw_code = <?php echo $tpw_code; ?>;
				<?php
			}
			?>
			
			jQuery(".tpw_code").val(tpw_code);
			
			
			var preview_status = '<?php echo  __("Online", "autochat-button-for-mobile-chat"); ?>';
			var preview_message = '<?php echo __("Hello! How can I help you?", "autochat-button-for-mobile-chat"); ?>';
			var preview_button = '<?php echo __("Start Chat", "autochat-button-for-mobile-chat"); ?>';
			var preview_image = '<?php echo AUYTPW_DIR ."/assets/img/green2-round.png"; ?>';
			
			jQuery("input[name='tpw_name']").on("keyup", function(){
				
				if(jQuery(this).val() == ""){
					jQuery('.tpwin_container .info .name').html("Autochat");
				}else{
					jQuery('.tpwin_container .info .name').html(jQuery(this).val());
				}
				
			});
			
			jQuery("input[name='tpw_status']").on("keyup", function(){
				
				if(jQuery(this).val() == ""){
					jQuery('.tpwin_container .info .status').html(preview_status);
				}else{
					jQuery('.tpwin_container .info .status').html(jQuery(this).val());
				}
				
			});
			
			jQuery("select[name='tpw_position']").on("change", function(){
				console.log("adasd");
				if(jQuery(this).val() == "right"){
					jQuery('.tpwin_container .tpw_widget_icon').attr("class", "tpw_widget_icon right");
				}else{
					jQuery('.tpwin_container .tpw_widget_icon').attr("class", "tpw_widget_icon left");
				}
				
			});
			
			jQuery("textarea[name='tpw_intro_message']").on("keyup", function(){
				
				if(jQuery(this).val() == ""){
					jQuery('.tpwin_container .body .message').html(preview_message);
				}else{
					jQuery('.tpwin_container .body .message').html(jQuery(this).val());
				}
				
			});
			
			jQuery("input[name='tpw_button']").on("keyup", function(){
				
				if(jQuery(this).val() == ""){
					jQuery('.tpwin_container .footer .btn span').html(preview_button);
				}else{
					jQuery('.tpwin_container .footer .btn span').html(jQuery(this).val());
				}
				
			});
			
			jQuery("input[name='tpw_button_style']").on("click", function(){
				
				if(jQuery(this).val() == ""){
					jQuery('.tpw_widget_icon img').attr('src', preview_image);
				}else{
					jQuery('.tpw_widget_icon img').attr('src', jQuery(this).val());
				}
				
			});
			
			jQuery("input[name='tpw_window']").on("click", function(){
				
				if(jQuery(this).attr("checked") == "checked"){
					jQuery('.tpw_window_preview').hide();
					jQuery(".tpw_widget_icon a").attr("target", "_blank");
				}else{
					jQuery('.tpw_window_preview').show();
					jQuery(".tpw_widget_icon a").attr("href", "#");
					jQuery(".tpw_widget_icon a").removeAttr("target");
				}
				
			});
			
			jQuery("input[name='tpw_number'], textarea[name='tpw_message'], select[name='tpw_code'], input[name='tpw_window']").on("keyup change click", function(){
				
				//get link
				var message = jQuery("textarea[name='tpw_message']").val();
				var country = jQuery("select[name='tpw_code']").val();
				var number = jQuery("input[name='tpw_number']").val();
			
				var params = {
					"message" : message,
					"country" : country,
					"number" : number,
					"action":"auytpw_ajax_whatsapp_link"
				};
				
				
				jQuery.ajax({
					data:  params,
					url:   '<?php echo admin_url("admin-ajax.php"); ?>',
					type:  'post',
					
					success:  function (response) {
						jQuery(".tpwin_container .footer .btn").attr("href", response);
						if(jQuery("input[name='tpw_window']").attr("checked") == "checked"){
							jQuery(".tpw_widget_icon a").attr("href", response);
						}else{
							jQuery(".tpw_widget_icon a").attr("href", "#");
						}
							
						
					},
							
				});
				
			});
			
			setInterval(function(){ 
				var image = jQuery(".tpw_img_stng").attr("src");
				jQuery(".tpwin_container .header .photo img").attr("src", image);
				console.log(image != "");
				if(image != ""){
					jQuery(".tpwin_container .header .photo").css("max-width", "60px");
					jQuery(".tpwin_container .header .photo").css("min-width", "60px");
				}else{
					jQuery(".tpwin_container .header .photo").css("max-width", "0px");
					jQuery(".tpwin_container .header .photo").css("min-width", "0px");
				}
				
				
			}, 10);
			
		});
	</script>
	<?php
}

function auytpw_register_settings() { 
	register_setting( 'tpw_opt', 'tpw_intro_message');
	register_setting( 'tpw_opt', 'tpw_message' );
	register_setting( 'tpw_opt', 'tpw_number' );
	register_setting( 'tpw_opt', 'tpw_code' );
	register_setting( 'tpw_opt', 'tpw_name' );
	register_setting( 'tpw_opt', 'tpw_window' );
	register_setting( 'tpw_opt', 'tpw_status' );
	register_setting( 'tpw_opt', 'tpw_button' );
	register_setting( 'tpw_opt', 'tpw_position' );
	register_setting( 'tpw_opt', 'tpw_upload_image' );
	register_setting( 'tpw_opt', 'tpw_button_style' );
}

function auytpw_get_settings(){
	
	if(get_option('tpw_intro_message') == ""){
		$tpw_intro_message = __("Hello! How can I help you?", "autochat-button-for-mobile-chat");
	}else{
		$tpw_intro_message = get_option('tpw_intro_message');
	}
	
	if(get_option('tpw_message') == ""){
		$tpw_message = '';
	}else{
		$tpw_message = get_option('tpw_message');
	}
	
	if(get_option('tpw_number') == ""){
		$tpw_number = '';
	}else{
		$tpw_number = get_option('tpw_number');
	}
	
	if(get_option('tpw_code') == ""){
		$tpw_code = '';
	}else{
		$tpw_code = get_option('tpw_code');
	}
	
	if(get_option('tpw_name') == ""){
		$tpw_name = 'Autochat';
	}else{
		$tpw_name = get_option('tpw_name');
	}
	
	if(get_option('tpw_window') == ""){
		$tpw_window = 'off';
	}else{
		$tpw_window = get_option('tpw_window');
	}
	
	if(get_option('tpw_status') == ""){
		$tpw_status = __("Online", "autochat-button-for-mobile-chat");
	}else{
		$tpw_status = get_option('tpw_status');
	}
	
	if(get_option('tpw_button') == ""){
		$tpw_button = __("Start Chat", "autochat-button-for-mobile-chat");
	}else{
		$tpw_button = get_option('tpw_button');
	}
	
	if(get_option('tpw_position') == ""){
		$tpw_position = '';
	}else{
		$tpw_position = get_option('tpw_position');
	}
	
	if(get_option('tpw_button_style') == ""){
		$tpw_button_style = AUYTPW_DIR .'/assets/img/green2-round.png';
	}else{
		$tpw_button_style = get_option('tpw_button_style');
	}
	
	$tpw_upload_image = get_option('tpw_upload_image');
	
	$link = auytpw_whatsapp_link($tpw_code, $tpw_number, $tpw_message);
	
	$tpw_settings = array( 
		'pluginUrl'		=> AUYTPW_DIR,
		'intro_message' => $tpw_intro_message,
		'name' 			=> $tpw_name,
		'link' 			=> $link,
		'status' 		=> $tpw_status,
		'button' 		=> $tpw_button,
		'position' 		=> $tpw_position,
		'profileImage' 	=> $tpw_upload_image,
		'windowHtml' 	=> $tpw_window,
		'button_style' 	=> $tpw_button_style,
	);
	
	return $tpw_settings;
	
}
  
function auytpw_whatsapp_link($tpw_code, $tpw_number, $tpw_message){
	$link = "";

	if($tpw_code <> "" and $tpw_number <> ""){
		
		$link = "https://wa.me/".$tpw_code.$tpw_number;
 
	}
	
	if($tpw_message <> ""){
		$msj = urlencode($tpw_message);
		$link .= "?text=$msj";
	}
	
	return $link;
}

function auytpw_ajax_whatsapp_link(){
	
	echo auytpw_whatsapp_link($_POST['country'], $_POST['number'], $_POST['message']);
	
	wp_reset_postdata();
	
	die();
}
add_action('wp_ajax_auytpw_ajax_whatsapp_link', 'auytpw_ajax_whatsapp_link');
add_action('wp_ajax_nopriv_auytpw_ajax_whatsapp_link', 'auytpw_ajax_whatsapp_link');

  ?>