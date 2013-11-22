<div class="page-header">
	<h1>Orders</h1>
</div>
    <?php 
        $this->widget('zii.widgets.grid.CGridView', array(
    		'dataProvider'=>$dataProvider,
    		'itemsCssClass' => 'table table-bordered table-striped',
    		'cssFile' => '',
    		'filter'=>$OrderFilter,
    		'columns'=>array(
    			array(
    			    'name'=>'id',
    			    'header'=>'Order #',
    			    'filter'=>false,
    			),
                array(            // display 'create_time' using an expression
                    'name'=>'user_first_name',
                   'value'=>'$data->user->first_name',
                ),
                array(            // display 'create_time' using an expression
                    'name'=>'user_last_name',
                   'value'=>'$data->user->last_name',
                ),
                array(            // display 'create_time' using an expression
                    'name'=>'user_email_address',
                    'value'=>'$data->user->email_address',
                ),
                array(            // display 'create_time' using an expression
                    'name'=>'total',
    				'type'=>'raw',
    				'filter'=>false,  
                    'value'=>'"&pound;" . number_format((float)$data->total, 2, ".", "")',
                ),
                array(            // display 'create_time' using an expression
                    'name'=>'paid',
                    'header'=>'Status',
                    'filter'=>array('1'=>'Paid','0'=>'Unpaid'),
                    'value'=>'($data->paid ? "Paid" : "Unpaid")',
                ),
    			array(            // display 'create_time' using an expression
                    'name'=>'created_date',
                    'filter'=>false,
                    'value'=>'date("d/m/Y H:i", strtotime($data->created_date))',
                ),
                /* array(            // display 'create_time' using an expression
                    'name'=>'updated_date',
                    'filter'=>false,
                    'value'=>'date("d/m/Y H:i", strtotime($data->updated_date))',
                ), */
    			'actions'=>array(
    				'header'=>'Actions',
    				'type'=>'raw',
    				//'value'=> "CHtml::link('Update',array('searchterm/update', 'id' => \$data->id), array('class' => 'btn')) . ' ' . CHtml::link('Delete',array('searchterm/delete', 'id' => \$data->id), array('class' => 'btn btn-danger'))"
    				'value'=> "CHtml::link('Update',array('order/update', 'id' => \$data->id), array('class' => 'btn'))"
    			),
    		)
    	)); 
    ?>