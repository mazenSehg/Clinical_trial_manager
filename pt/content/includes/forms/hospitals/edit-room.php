<?php 
// if accessed directly than exit
if (!defined('ABSPATH')) exit;

$id = $_GET['id'];
$result = get_tabledata(TBL_ROOMS,true,array('ID' => $id));

if( !user_can('edit_room') ):
	echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
elseif(!can_access('room', $id)):
	echo page_not_found('Oops ! You are not allowed to view this page.','Please check other pages !');
elseif(!$result):
	echo page_not_found('Oops ! Room Details Not Found.','Please go back and check again !');
else:
?>
	<form class="edit-room" method="post" autocomplete="off">
		<div class="form-group">
			<label for="name">Room Name <span class="required">*</span></label>
			<input type="text" name="name" class="form-control require" value="<?php echo stripslashes($result->name);?>"/>
		</div>
		
        
		<?php if(is_admin()): ?>
		<div class="form-group">
			<label for="hostipals">Hospital <span class="required">*</span></label>
			<select name="hospital" class="form-control select_single require" tabindex="-1" data-placeholder="Choose hospital" >
				<?php
				$args = (!is_admin()) ? array('ID' => get_current_user_hospital()) : array();
				$data = get_tabledata(TBL_HOSPITALS,false,$args);
				$option_data = get_option_data($data,array('ID','name'));
				echo get_options_list($option_data,array($result->hospital));
				?>
			</select>
		</div>
		<?php else: ?>
			<input type="hidden" name="hospital" value="<?php echo get_current_user_hospital();?>" class="require"/>
		<?php endif; ?>
		<div class="ln_solid"></div>
		<div class="form-group">
			<input type="hidden" name="action" value="edit_room"/>
			<input type="hidden" name="room_id" value="<?php echo $id;?>"/>
			<button class="btn btn-success btn-md" type="submit">Update Room</button>
		</div>
	</form>
<?php endif; ?>