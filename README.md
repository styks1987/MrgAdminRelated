## Introduction

This relation helper is designed to allow the user to click a button and duplicate a set of fields. This is useful if you are editing an item that hasMany of another item.

In the example code, we have a piece of Salvage that hasMany SalvageDrivetrain.

## Setup

### In your AppHelper

```php5
	/**
		*  Function Name: row
		*  Description: row	used for outputting a row with elements
		*  Date Added: Mon, Nov 11, 2013
	*/
	function row($elements, $options=[]){
		$cols = '';
		foreach($elements as $el){
			$cols .= $this->div($el[0],$el[1]);
		}
		$class = (!empty($options['class']))? 'row '.$options['class']: 'row';
		return $this->div($class, $cols, $options);
	}
```

### In your Controller

```php5
	var $helpers = ['MrgAdminRelated.MrgAdminRelated'];
```

### In your form

```php5
		// This will produce several rows to edit drivetrains
		$this->MrgAdminRelated->init('SalvageDrivetrain',[
				[
					'col-sm-3',
					'engine_make'
				],
				[
					'col-sm-3',
					'engine_model'
				],
				[
					'col-sm-2',
					'engine_hours'
				],
				[
					'col-sm-3',
					'transmission'
				],
				[
					'col-sm-1',
					null,
					['content'=>$this->Html->link('Delete', 'javascript:void(0)', ['class'=>'repeater_delete btn btn-danger', 'style'=>'margin-top:24px;'])]
				]
			]
		).
		$this->Html->row([
			[
				'col-sm-6',
				$this->Html->link('Add Drivetrain', 'javascript:void(0)', ['id'=>'repeater_add', 'class'=>'btn btn-info'])
			]
		])
```

### In your Javascript ready event
```javascript
	$('.repeater_group_container').repeater({model:'SalvageDrivetrain', group_delete_url:'/admin/mrg_admin_related/mrg_admin_relations/delete/'});
```
