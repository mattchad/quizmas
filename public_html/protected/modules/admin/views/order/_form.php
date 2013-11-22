<div class="tabbable">  
<ul class="nav nav-tabs">
	<li class="active"><?php echo CHtml::link('Details', '#details', array('data-toggle'=>'tab')); ?></li>
	<li><?php echo CHtml::link('Contents', '#contents', array('data-toggle'=>'tab')); ?></li>
	<li><?php echo CHtml::link('Billing Address', '#billing', array('data-toggle'=>'tab')); ?></li>
	<li><?php echo CHtml::link('Delivery Address', array('#delivery'), array('data-toggle'=>'tab')); ?></li>
	<li><?php echo CHtml::link('Order Status', array('#status'), array('data-toggle'=>'tab')); ?></li>
</ul>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>
    <div class="tab-content">  
    	<div class="tab-pane active" id="details">
    	    <table class="table details_table">
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('id');?>: </td>
        	        <td><?php echo $Order->id; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->user->getAttributeLabel('fullname');?>: </td>
        	        <td><?php echo $Order->user->fullname; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('postage');?>: </td>
        	        <td><?php echo '&pound;' . number_format((float)$Order->postage, 2, ".", ""); ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('total');?>: </td>
        	        <td><?php echo '&pound;' . number_format((float)$Order->total, 2, ".", ""); ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('paid');?>: </td>
        	        <td><?php echo ($Order->paid ? 'Yes' : 'No'); ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('created_date');?>: </td>
        	        <td><?php echo date('l jS F Y - H:i', strtotime($Order->created_date)); ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->getAttributeLabel('updated_date');?>: </td>
        	        <td><?php echo date('l jS F Y - H:i', strtotime($Order->updated_date)); ?></td>
    	        </tr>
    	    </table>
    	</div>
    	<div class="tab-pane" id="contents">
    	    <table class="table table-striped table-bordered details_table">
    	            <tr>
    	                <th>Product</th>
    	                <th>Details</th>
    	                <th class="center">Quantity</th>
    	                <th class="center">Price</th>
    	                <th class="center">Total</th>
    	            </tr>
    	        <?php foreach($Order->contents as $OrderItem){ ?>
    	            <tr>
    	                <td><?php echo $OrderItem->name; ?></td>
    	                <td><?php echo $OrderItem->details; ?></td>
    	                <td class="center"><?php echo $OrderItem->quantity; ?></td>
                        <td class="center"><?php echo '&pound;' . number_format((float)$OrderItem->price, 2, ".", ""); ?></td>
    	                <td class="center"><?php echo '&pound;' . number_format((float)($OrderItem->price * $OrderItem->quantity) , 2, ".", ""); ?></td>
    	            </tr>
    	        <?php } ?>
    	            <tr>
    	                <td class="right" colspan="4">Total: </td>
    	                <td class="center"><strong><?php echo '&pound;' . number_format((float)$Order->total, 2, ".", ""); ?><strong></tr>
    	            </tr>
    	    </table>
    	</div>
    	<div class="tab-pane" id="billing">
    	    <table class="table details_table">
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('first_name');?>: </td>
        	        <td><?php echo $Order->billingAddress->first_name; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('last_name');?>: </td>
        	        <td><?php echo $Order->billingAddress->last_name; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('company');?>: </td>
        	        <td><?php echo $Order->billingAddress->company; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('address_1');?>: </td>
        	        <td><?php echo $Order->billingAddress->address_1; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('address_2');?>: </td>
        	        <td><?php echo $Order->billingAddress->address_2; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('city');?>: </td>
        	        <td><?php echo $Order->billingAddress->city; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('post_code');?>: </td>
        	        <td><?php echo $Order->billingAddress->post_code; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('country');?>: </td>
        	        <td><?php echo $Order->billingAddress->country; ?></td>
    	        </tr>
    	    </table>
    	</div>
    	<div class="tab-pane" id="delivery">
    	    <?php if(sizeof($Order->deliveryAddress)){ ?>
    	    <table class="table details_table">
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('first_name');?>: </td>
        	        <td><?php echo $Order->billingAddress->first_name; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('last_name');?>: </td>
        	        <td><?php echo $Order->billingAddress->last_name; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('company');?>: </td>
        	        <td><?php echo $Order->billingAddress->company; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('address_1');?>: </td>
        	        <td><?php echo $Order->billingAddress->address_1; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('address_2');?>: </td>
        	        <td><?php echo $Order->billingAddress->address_2; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('city');?>: </td>
        	        <td><?php echo $Order->billingAddress->city; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('post_code');?>: </td>
        	        <td><?php echo $Order->billingAddress->post_code; ?></td>
    	        </tr>
    	        <tr>
        	        <td class="attribute_label"><?php echo $Order->billingAddress->getAttributeLabel('country');?>: </td>
        	        <td><?php echo $Order->billingAddress->country; ?></td>
    	        </tr>
    	    </table>
    	    <?php } else { ?>
    	        <p>This order has been marked for collection at CLPE, or doesn't require delivery</p>
    	    <?php } ?>
    	</div>
    	<div class="tab-pane" id="status">
        	<div class="control-group">
        		<?php echo $form->labelEx($Order,'paid', array('class'=>'control-label')); ?>
        		<div class="controls">
        			<?php echo $form->dropDownList($Order,'paid',array('1'=>'Yes', '0'=>'No')); ?>
        			<?php echo $form->error($Order,'paid'); ?>
        		</div>
        	</div>
    	</div>
    </div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($Order->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>