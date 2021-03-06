<?php 
// if accessed directly than exit
if (!defined('ABSPATH')) exit;

$id = $_GET['id'];
$result = get_tabledata(TBL_TREATMENTS,true,array('ID'=>$id));

if( !user_can('edit_treatment') ):
	echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
elseif(!can_access('treatment', $id)):
	echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
elseif(!$result):
	echo page_not_found('Oops ! Treatment Details Not Found.','Please go back and check again !');
else:
?>
	<form class="edit-treatment" method="post" autocomplete="off">
		<div class="form-group">
			<label for="name">Name <span class="required">*</span></label>
			<input type="text" name="name" class="form-control require" value="<?php echo stripslashes($result->name);?>"/>
		</div>
		<?php if(is_admin()): ?>
		 
		<?php else: ?>
			<input type="hidden" name="hospital" value="<?php echo get_current_user_hospital();?>" class="require"/>
		<?php endif; ?>
		<div class="form-group">
			<label for="trial">Trial <span class="required">*</span></label>
			<select name="trial" class="form-control select_single require" data-placeholder="Choose Trial" tabindex="-1">
				<?php
					$args = (!is_admin()) ? array('hospital' => get_current_user_hospital()) : array();
					$data = get_tabledata(TBL_TRIALS,false,$args);
					$option_data = get_option_data($data,array('ID','name'),true);
					echo get_options_list($option_data,maybe_unserialize($result->trial));
					?>
			</select>
		</div>
		<div class="form-group">
			<label for="weight">Weight <span class="required">*</span></label>
			<input  type="number" name="weight" class="form-control require" value="<?php echo $result->weight;?>" min="0" max="100"/>
		</div>
        
        
        
        
        
        
        
                                <div class = "form-group">
<label for ="color">Identification Color for Treatment <span class="required">*</span></label>
                    <select name = "colour" class="form-control dropdown-toggle">
                        
                                                <option selected="<?php echo $result->colour;?>">
                                                    
                                                    <?php 
    if($result->colour == "#FF0000"){
    echo "Red";
    }elseif($result->colour == "#FFA500"){
    echo "Orange";
    }elseif($result->colour == "#FFFF00"){
    echo "Yellow";
    }elseif($result->colour == "#80FF00"){
    echo "Green";
    }elseif($result->colour == "#00FFFF"){
    echo "Blue";
    }elseif($result->colour == "#0000FF"){
    echo "Indigo";
    }elseif($result->colour == "#7F00FF"){
    echo "Violet";
    }
                                                    ?>
                        </option>
    <option value="#FF0000" style="background: #FF0000">Red             </option>
    <option value="#FFA500" style="background: #FFA500">Orange             </option>
    <option value="#FFFF00" style="background: #FFFF00"> Yellow            </option>
    <option value="#80FF00" style="background: #80FF00">Green           </option>
    <option value="#00FFFF" style="background: #00FFFF">Blue               </option>
    <option value="#0000FF" style="background: #0000FF">Indigo             </option>
    <option value="#7F00FF" style="background: #7F00FF">Violet             </option>


                        </select>
        </div>
        
        
        
		<div class="ln_solid"></div>
		<div class="form-group">
			<input type="hidden" name="action" value="edit_treatment"/>
			<input  type="hidden" name="treatment_id" value="<?php echo $result->ID;?>"/>
			<button class="btn btn-success btn-md" type="submit">Update Treatment</button>
		</div>
	</form>
<?php endif; ?>