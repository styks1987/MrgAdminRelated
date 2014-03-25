	/* ********* REPEATER ************* */
	/* Add/Delete Associated model data */


	(function ($){
		$.widget("Merge.repeater", {
			options : {
				add_button:'#repeater_add', // The id for the add button at the bottom of the group container
				delete_button:'.repeater_delete', // The class for the delete buttons placed at the end of each row
				group_name : 'Item', // Description used for alerts
				group:'.repeater_group', // A group of elements that consitute the entirety of a single repeatable element
				group_container: '.repeater_group_container', // The container that holds all the groups
				group_delete_url : '#',
				model : '#'
			},
			_create: function () {
				this._setup_events();
			},

			_setup_events:function(){
				$(this.options.add_button).click(this._repeat.bind(this));
				$(this.options.delete_button).click(function (e){this._delete(e)}.bind(this));
			},

			_clear_events:function(){
				$(this.options.add_button).unbind();
				$(this.options.delete_button).unbind();
			},

			_repeat : function () {
				// Turn off our events
				this._clear_events();
				// Get how many items are in the group
				this.group_length = $(this.options.group).length;
				// Grab the last item and use it as our template
				this.template = $(this.options.group).last().clone()
				// Change all the input names by incrementing the number in the name
				this._set_input_names();
				// Add the new items to the page
				this.template.appendTo(this.options.group_container);
				// Turn the events back on
				this._setup_events();
			},
			// Increment the names
			// Remove values from cloned element
			_set_input_names : function () {
				// Find all the inputs and increment the number in their name
				this.template.find('input,select,textarea').attr('name', function(i, cur) {
					return cur.replace(this.group_length - 1, this.group_length )
				}.bind(this)).end();
				// Find all the input ids and increment the number in their id
				this.template.find('input,select,textarea').attr('id', function (i, cur){
					return cur.replace(this.group_length - 1, this.group_length )
				}.bind(this)).end();
				// Find all the labels and update their for attribute by incrementing their ids
				this.template.find('label').attr('for', function (i, cur){
					return cur.replace(this.group_length - 1, this.group_length )
				}.bind(this)).end();
				// Clear the values if we cloned a group with values in it
				this.template.find('input,select,textarea').val('');
				this.template.find('input[type=checkbox]').attr('checked', false);

			},
			// Delete an element from the list
			// if it exists in the DB, delete it
			_delete : function (e) {
				if(confirm('Are you sure you want to delete this '+this.options.group_name+'?')){
					// Get our groups outer most element
					var group = $(e.target).closest(this.options.group);
					// Get ths id if it exists so we can delete it
					var item_id  = group.attr('data-id');
					// If no id exists just delete it.
					if (item_id == '') {
						group.remove();
					}else{
						$.ajax({url:this.options.group_delete_url+'/'+this.options.model+'/'+item_id,method:'post', complete:function (){
							group.remove();
						}});
					}
				}
			}
		})
	})(jQuery);
